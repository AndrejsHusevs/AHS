import React, { useState, useEffect } from 'react';

const ProductGrid = ({ categoryId, onProductSelect }) => {
    const [products, setProducts] = useState([]);
    const [error, setError] = useState(null);
    const [selectedProduct, setSelectedProduct] = useState(null);

    useEffect(() => {
        const fetchProducts = async () => {
            const query = `
                query ($categoryId: Int) {
                    products(categoryId: $categoryId) {
                        id
                        name                        
                        gallery
                        price_amount                        
                        price_currency_symbol
                    }
                }
            `;
            try {
                const response = await fetch('/ahs/public/graphql', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ query, variables: { categoryId } }),
                });
                const result = await response.json();
                if (result.errors) {
                    setError('Failed to fetch products');
                } else {
                    setProducts(result.data.products);
                }
            } catch (error) {
                setError('Failed to fetch products');
            }
        };

        fetchProducts();
    }, [categoryId]);

    const handleProductSelect = async (productId) => {
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
                        items {
                            id
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
                body: JSON.stringify({ query, variables: { productId } }),
                //body: JSON.stringify({ query }),
            });
            const result = await response.json();
            if (result.errors) {
                setError('Failed to fetch product details (5)');
            } else {
                setSelectedProduct(result.data.product);
                onProductSelect(result.data.product);
            }
        } catch (error) {
            setError('Failed to fetch product details (6)');
        }
    };

    if (error) {
        return <div className="text-danger">{error}</div>;
    }

    return (
        <div className="container">
            <div className="row">
                {products.map((product) => (
                    <div key={product.id} className="col-lg-4 col-md-6 mb-4">
                        <div className="card h-100" onClick={() => handleProductSelect(product.id)}>
                            <img src={product.gallery[0]} className="card-img-top" alt={product.name} />
                            <div className="card-body">
                                <h5 className="card-title">{product.name}</h5>
                                <p className="card-text"><strong>Price:</strong> {product.price_currency_symbol} {product.price_amount}</p>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default ProductGrid;