// src/index.js
import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import Header from './components/Header';
import ProductGrid from './components/ProductGrid';
import ProductDetail from './components/ProductDetail';
import CartOverlay from './components/CartOverlay';

const App = () => {
    const [selectedCategory, setSelectedCategory] = useState(0);
    const [selectedProduct, setSelectedProduct] = useState(null);
    const [cartItems, setCartItems] = useState(() => {
        const savedCart = localStorage.getItem('cartItems');
        return savedCart ? JSON.parse(savedCart) : [];
    });
    const [isCartVisible, setIsCartVisible] = useState(false);

    useEffect(() => {
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
    }, [cartItems]);

    const handleCategorySelect = (categoryId) => {
        console.log("Category selected (index.js App):", categoryId); // Debugging statement
        setSelectedCategory(categoryId);
        setSelectedProduct(null); // Reset selected product when category changes
    };

    const handleProductSelect = async (productId) => {
        console.log('(in index.js) Product selected with ID:', productId);
        const query = `
            query ($productId: String!) {
                product(id: $productId) {
                    id
                    name
                    gallery
                    price_amount
                    price_currency_symbol
                    description
                    attributes {
                        id
                        name
                        type
                        items {
                            id
                            value
                            display_value
                        }
                    }
                }
            }
        `;

        try {
            const response = await fetch('/ahs/public/graphql', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ query, variables: { productId: String(productId) } }), // Ensure productId is a string
            });
            const result = await response.json();
            if (result.errors) {
                console.error('Failed to fetch product details (5 - index.js)', result.errors);
            } else {
                console.log('Fetched product details:', result.data.product);
                setSelectedProduct(result.data.product);
            }
        } catch (error) {
            console.error('Failed to fetch product details (6 - index.js)', error);
        }
    };

    const handleAddToCart = (product) => {

        console.log('(handleAddToCart) Adding item to cart:', product);

        const existingItemIndex = cartItems.findIndex((item) => 
            item.id === product.id && 
            JSON.stringify(item.selectedAttributes) === JSON.stringify(product.selectedAttributes)
        );
        console.log('Existing item index:', existingItemIndex);

        if (existingItemIndex !== -1) {
            const updatedItems = [...cartItems];
            updatedItems[existingItemIndex].quantity++;
            setCartItems(updatedItems);            
        } else {
            product.quantity = 1;
            setCartItems((cartItems) => [...cartItems, product]);
        }

        
        
        setIsCartVisible(true);        
    };


    const onIncreaseQuantity = (index) => {
        console.log('onIncreaseQuantity:', index);
        setCartItems((cartItems) => {
            const updatedItems = [...cartItems];
            updatedItems[index].quantity += 1;
            return updatedItems;
        });
    };
    
    const onDecreaseQuantity = (index) => {
        console.log('onDecreaseQuantity:', index);
        setCartItems((cartItems) => {
            const updatedItems = [...cartItems];
            if (updatedItems[index].quantity > 1) {
                updatedItems[index].quantity -= 1;
            } else {
                console.log('Removing item at index:', index);
                handleRemoveItem(index)
            }
            return updatedItems;
        });
    };


    const handleCartClick = () => {
        console.log('Cart button clicked');
        setIsCartVisible(true);
    };

    const handleCartClose = () => {
        console.log('Cart close button clicked');
        setIsCartVisible(false);
    };

    const handleRemoveItem = (index) => {
        console.log('Removing item at index:', index);
        /*setCartItems((prevItems) => prevItems.filter((_, i) => i !== index));*/

        setCartItems(cartItems.filter((_, i) => i !== index));

    };

    const handleMakeOrder = async () => {
        console.log('Making order with items:', cartItems);
        const content = cartItems.map(item => {
            const attributes = Object.keys(item.selectedAttributes).map(attrId => {
                const attr = item.selectedAttributes[attrId];
                return `${attr.name}: ${attr.value}`;
            }).join(', ');
            return `${item.product.name}, qty: ${item.quantity} (${attributes})`;
        }).join('; ');

        const response = await fetch('/ahs/public/graphql', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                query: `
                    mutation {
                        createOrder(content: "${content}")
                    }
                `,
            }),
        });

        const result = await response.json();
        if (result.data.createOrder) {
            setCartItems([]);
            alert('Order added');
        } else {
            alert('Failed to add order');
        }
    };

    return (
        <div>
            <Header 
                onCategorySelect={handleCategorySelect} 
                onCartClick={handleCartClick} 
                categories={[]} // Pass categories if available
                selectedCategory={selectedCategory} // Pass selectedCategory
            />
            {selectedProduct ? (
                <ProductDetail product={selectedProduct} onAddToCart={handleAddToCart} />
            ) : (
                <ProductGrid categoryId={selectedCategory} onProductSelect={handleProductSelect} cartItems={cartItems} />
            )}
            {isCartVisible && (
                <CartOverlay
                    cartItems={cartItems}
                    onClose={handleCartClose}
                    onRemoveItem={handleRemoveItem}
                    onMakeOrder={handleMakeOrder}
                    onDecreaseQuantity={onDecreaseQuantity}
                    onIncreaseQuantity={onIncreaseQuantity}
                />
            )}
        </div>
    );
};

ReactDOM.render(<App />, document.getElementById('root'));