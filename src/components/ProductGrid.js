// src/components/ProductGrid.js
import React, { useState, useEffect } from 'react';

const ProductGrid = ({ categoryId, onProductSelect }) => {
    const [products, setProducts] = useState([]);
    const [error, setError] = useState(null);
    const [categoryName, setCategoryName] = useState('');

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

        const fetchCategoryName = async (categoryId) => {
            if (!categoryId) {
                categoryId = 0;
            }
        
            const query = `
                query ($categoryId: Int!) {
                    categories(id: $categoryId) {
                        name
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
                console.log(result); // Debugging: Log the result to see the structure
        
                if (result.errors && result.errors.length > 0) {
                    console.error(result.errors); // Log the errors for debugging
                    setError('Failed to fetch category name (1)');
                } else {
                    if (result.data.categories && result.data.categories.length > 0) {
                        setCategoryName(result.data.categories[0].name);
                    } else {
                        setError('Category not found');
                    }
                }
            } catch (error) {
                console.error(error); // Log the error for debugging
                setError('Failed to fetch category name (2)');
            }
        };

        fetchProducts();
        fetchCategoryName(categoryId);
    }, [categoryId]);

    if (error) {
        return <div className="text-danger">{error}</div>;
    }

    return (
        <div className="container">
            <h2 className="category-title">{categoryName}</h2>
            <div className="row">
                {products.map((product) => (
                    <div key={product.id} className="col-lg-4 col-md-6 mb-4">
                        <div className="card h-100" onClick={() => onProductSelect(product.id)}>
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