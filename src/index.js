import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import Header from './components/Header';
import ProductGrid from './components/ProductGrid';

const App = () => {
    const [selectedCategory, setSelectedCategory] = useState(null);

    const handleCategorySelect = (categoryId) => {
        console.log("Category selected:", categoryId); // Debugging statement
        setSelectedCategory(categoryId);
    };

    return (
        <div>
            <Header onCategorySelect={handleCategorySelect} />
            {selectedCategory !== null && <ProductGrid categoryId={selectedCategory} />}
        </div>
    );
};

ReactDOM.render(<App />, document.getElementById('root'));