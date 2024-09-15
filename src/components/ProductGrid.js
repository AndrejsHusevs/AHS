import React, { useState, useEffect } from 'react';


const ProductGrid = ({ categoryId }) => {
    const [products, setProducts] = useState([]);
    const [error, setError] = useState(null);
    const [selectedProduct, setSelectedProduct] = useState(null);

    useEffect(() => {
        const fetchProducts = async () => {
            console.log("Fetching products for categoryId:", categoryId); // Debugging statement
            const query = `
                query ($categoryId: Int) {
                    products(categoryId: $categoryId) {
                        id
                        name
                        description
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

    if (error) {
        return <div className="text-danger">{error}</div>;
    }

    

    if (selectedProduct) {
        return (
            <div className="product-detail">
                <button className="btn btn-secondary mb-3" onClick={() => setSelectedProduct(null)}>Back to Products</button>
                <div className="card">
                    <img src={selectedProduct.gallery[0]} className="card-img-top" alt={selectedProduct.name} />
                    <div className="card-body">
                        <h3 className="card-title">{selectedProduct.name}</h3>
                        <p className="card-text">{selectedProduct.description}</p>
                        <p className="card-text"><strong>Price:</strong> ${selectedProduct.price_currency_symbol} ${selectedProduct.price_amount}</p>
                    </div>
                </div>
            </div>
        );
    }

    return (
        <div className="container">
            <div className="row">
                {products.map((product) => (
                    <div key={product.id} className="col-lg-4 col-md-6 mb-4">
                        <div className="card h-100" onClick={() => setSelectedProduct(product)}>
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