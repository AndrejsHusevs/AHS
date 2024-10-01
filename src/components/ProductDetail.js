import React, { useState } from 'react';

const ProductDetail = ({ product, onAddToCart }) => {
    const [currentImageIndex, setCurrentImageIndex] = useState(0);
    const [selectedAttributes, setSelectedAttributes] = useState({});

    const handleThumbnailClick = (index) => {
        setCurrentImageIndex(index);
    };

    const handleNextImage = () => {
        setCurrentImageIndex((prevIndex) => (prevIndex + 1) % product.gallery.length);
    };

    const handlePrevImage = () => {
        setCurrentImageIndex((prevIndex) => (prevIndex - 1 + product.gallery.length) % product.gallery.length);
    };

    const handleAttributeSelect = (attributeId, itemId) => {
        setSelectedAttributes((prevSelected) => ({
            ...prevSelected,
            [attributeId]: itemId,
        }));
    };

    const handleAddToCart = () => {
        const attributesWithNames = product.attributes.reduce((acc, attribute) => {            
            acc[attribute.id] = {
                name: attribute.name,
                type: attribute.type,
                id: attribute.id,
                value: selectedAttributes[attribute.id]
            };
            return acc;
        }, {});
        onAddToCart({ product, selectedAttributes: attributesWithNames });
    };

    return (
        <div className="product-detail container">
            <div className="row">
                {/* Left column with small product pictures */}
                <div className="col-2 thumbnails-container">
                    {product.gallery.map((image, index) => (
                        <img
                            key={index}
                            src={image}
                            className="img-thumbnail mb-2 thumbnail-image"
                            alt={`Thumbnail ${index}`}
                            onClick={() => handleThumbnailClick(index)}
                        />
                    ))}
                </div>
                {/* Middle column with large product picture */}
                <div className="col-7 position-relative image-container">
                    <img
                        src={product.gallery[currentImageIndex]}
                        className="img-fluid zoomed-image"
                        alt={product.name}
                    />
                    <button
                        className="btn btn-secondary position-absolute"
                        style={{ top: '50%', left: '10px', transform: 'translateY(-50%)' }}
                        onClick={handlePrevImage}
                    >
                        &lt;
                    </button>
                    <button
                        className="btn btn-secondary position-absolute"
                        style={{ top: '50%', right: '10px', transform: 'translateY(-50%)' }}
                        onClick={handleNextImage}
                    >
                        &gt;
                    </button>
                </div>
                {/* Right column with product details */}
                <div className="col-3">
                    <h3 className="card-title">{product.name}</h3>
                    <div className="card-text">
                        {product.attributes && product.attributes.map((attribute, index) => (
                            <div key={index}>
                                <strong>{attribute.name}:</strong>
                                <div className="attribute-items">
                                    
                                {attribute.items.map((item, idx) => {
                                    const isSwatch = attribute.type === 'swatch';
                                    const backgroundColor = isSwatch ? item.value : '';
                                    const isValidColor = /^#[0-9A-F]{6}$/i.test(backgroundColor) || /^(rgb|hsl)a?\((\d{1,3}%?,\s?){3,4}\)$/i.test(backgroundColor);

                                    if (isSwatch && !isValidColor) {
                                        console.warn(`Invalid color value: ${backgroundColor}`);
                                    }

                                    return (
                                        <button
                                            key={idx}
                                            className={`btn btn-sm ${selectedAttributes[attribute.id] === item.id ? 'btn-primary' : 'btn-outline-primary'}`}
                                            onClick={() => handleAttributeSelect(attribute.id, item.id)}
                                            style={isSwatch && isValidColor ? { backgroundColor, border: '1px solid #ccc', width: '24px', height: '24px' } : {}}
                                        >
                                            {isSwatch ? '' : item.display_value}
                                        </button>
                                    );
                                })}
                                </div>
                            </div>
                        ))}
                    </div>
                    <p className="card-text"><strong>Price:</strong> {product.price_currency_symbol} {product.price_amount}</p>
                    <button className="btn btn-primary" onClick={handleAddToCart}>Add to Cart</button>
                </div>
            </div>
            {/* Full width description below */}
            <div className="row mt-4">
                <div className="col-12">
                    <div dangerouslySetInnerHTML={{ __html: product.description }} />
                </div>
            </div>
        </div>
    );
};

export default ProductDetail;