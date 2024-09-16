import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import Header from './components/Header';
import ProductGrid from './components/ProductGrid';
import ProductDetail from './components/ProductDetail';

const App = () => {
    const [selectedCategory, setSelectedCategory] = useState(null);
    const [selectedProduct, setSelectedProduct] = useState(null);

    const handleCategorySelect = (categoryId) => {
        console.log("Category selected:", categoryId); // Debugging statement
        setSelectedCategory(categoryId);
        setSelectedProduct(null); // Reset selected product when category changes
    };

    const handleProductSelect = (product) => {
        setSelectedProduct(product);
    };

    return (
        <div>
            <Header onCategorySelect={handleCategorySelect} />
            {selectedProduct ? (
                <ProductDetail product={selectedProduct} />
            ) : (
                <ProductGrid categoryId={selectedCategory} onProductSelect={handleProductSelect} />
            )}
        </div>
    );
};

ReactDOM.render(<App />, document.getElementById('root'));