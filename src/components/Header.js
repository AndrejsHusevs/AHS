import React, { useState, useEffect } from 'react';
import logo from '../assets/brand-icon.png'; // Add your logo image here
import cartIcon from '../assets/shopping-cart.png'; // Add your cart icon image here

const Header = ({ onCategorySelect, onCartClick, categories: propCategories, selectedCategory }) => {
    const [categories, setCategories] = useState([]);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchCategories = async () => {
            const query = `
                query {
                    categories {
                        id
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
                    body: JSON.stringify({ query }),
                });
                const result = await response.json();
                if (result.errors) {
                    setError('Failed to fetch categories');
                } else {
                    setCategories(result.data.categories);
                }
            } catch (error) {
                setError('Failed to fetch categories');
            }
        };

        fetchCategories();
    }, []);

    const handleCategoryClick = (categoryId) => {    
        console.log("Category clicked:", categoryId); // Debugging statement    
        onCategorySelect(categoryId);
    };

    return (
        <header className="header">
            <div className="container">
                <div className="row justify-content-between align-items-center">
                    <div className="col">
                        <nav className="nav">
                            {categories.map(category => {                                
                                return (
                                    <div key={category.id} className="nav-item">
                                        <a
                                            href="#"
                                            className={`category-name ${selectedCategory === category.id ? 'selected' : ''}`}
                                            onClick={() => handleCategoryClick(category.id)}
                                        >
                                            {category.name}
                                            {selectedCategory === category.id && <div className="category-underline"></div>}
                                        </a>
                                    </div>
                                );
                            })}
                        </nav>
                    </div>
                    <div className="col text-center">
                        <a href="/" className="logo-link">
                            <img src={logo} alt="Logo" className="logo-image" />
                        </a>
                    </div>
                    <div className="col text-right">
                        <button className="cart-button" onClick={onCartClick}>
                            <img src={cartIcon} alt="Cart" className="cart-icon" />
                        </button>
                    </div>
                </div>
            </div>
        </header>
    );
};

export default Header;