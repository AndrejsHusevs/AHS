import React, { useState } from 'react';

const ProductDetail = ({ product }) => {
    const [currentImageIndex, setCurrentImageIndex] = useState(0);

    const handleThumbnailClick = (index) => {
        setCurrentImageIndex(index);
    };

    const handleNextImage = () => {
        setCurrentImageIndex((prevIndex) => (prevIndex + 1) % product.gallery.length);
    };

    const handlePrevImage = () => {
        setCurrentImageIndex((prevIndex) => (prevIndex - 1 + product.gallery.length) % product.gallery.length);
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
                            className="img-thumbnail mb-2"
                            alt={`Thumbnail ${index}`}
                            style={{ width: '50px', height: '50px', cursor: 'pointer' }}
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
                        style={{ top: '50%', left: '0', transform: 'translateY(-50%)' }}
                        onClick={handlePrevImage}
                    >
                        &lt;
                    </button>
                    <button
                        className="btn btn-secondary position-absolute"
                        style={{ top: '50%', right: '0', transform: 'translateY(-50%)' }}
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
                                <ul>
                                    {attribute.items.map((item, idx) => (
                                        <li key={idx}>{item.displayValue}</li>
                                    ))}
                                </ul>
                            </div>
                        ))}
                    </div>
                    <p className="card-text"><strong>Price:</strong> {product.price_currency_symbol} {product.price_amount}</p>
                    <button className="btn btn-primary">Add to Cart</button>
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