// src/index.js
import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import Header from './components/Header';
import ProductGrid from './components/ProductGrid';
import ProductDetail from './components/ProductDetail';
import CartOverlay from './components/CartOverlay';

const App = () => {
    const [selectedCategory, setSelectedCategory] = useState(null);
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

    const handleProductSelect = (product) => {
        setSelectedProduct(product);
    };

    const handleAddToCart = (item) => {
        setCartItems((prevItems) => [...prevItems, item]);
    };

    const handleCartClick = () => {
        setIsCartVisible(true);
    };

    const handleCloseCart = () => {
        setIsCartVisible(false);
    };

    const handleRemoveItem = (index) => {
        setCartItems((prevItems) => prevItems.filter((_, i) => i !== index));
    };

    const handleMakeOrder = async () => {
        const content = cartItems.map(item => {
            const attributes = Object.keys(item.selectedAttributes).map(attrId => {
                const attr = item.selectedAttributes[attrId];
                return `${attr.name}: ${attr.value}`;
            }).join(', ');
            return `${item.product.name} (${attributes})`;
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
                <ProductGrid categoryId={selectedCategory} onProductSelect={handleProductSelect} />
            )}
            {isCartVisible && (
                <CartOverlay
                    cartItems={cartItems}
                    onClose={handleCloseCart}
                    onRemoveItem={handleRemoveItem}
                    onMakeOrder={handleMakeOrder}
                />
            )}
        </div>
    );
};

ReactDOM.render(<App />, document.getElementById('root'));