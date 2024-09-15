import React, { useState, useEffect } from 'react';

const Header = ({ onCategorySelect }) => {
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
        <header>
            <nav className="navbar navbar-expand-lg navbar-light bg-light">
                <div className="container">
                    <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span className="navbar-toggler-icon"></span>
                    </button>
                    <div className="collapse navbar-collapse" id="navbarNav">
                        <ul className="navbar-nav mr-auto">
                            {error ? (
                                <li className="nav-item">
                                    <span className="nav-link text-danger">{error}</span>
                                </li>
                            ) : (
                                categories.map((category) => (
                                    <li className="nav-item" key={category.id}>
                                        <a className="nav-link" href="#" onClick={() => handleCategoryClick(category.id)}>{category.name}</a>
                                    </li>
                                ))
                            )}
                        </ul>
                        <a className="navbar-brand ml-auto" href="/">Logo</a>
                    </div>
                </div>
            </nav>
        </header>
    );
};

export default Header;