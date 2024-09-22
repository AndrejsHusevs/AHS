// src/components/CartOverlay.js
import React from 'react';

const CartOverlay = ({ cartItems, onClose, onRemoveItem, onMakeOrder }) => {
    return (
        <div className="cart-overlay">
            <div className="cart-content">
                <button className="btn btn-secondary" onClick={onClose}>Close</button>
                <h3>Cart</h3>
                {cartItems.length === 0 ? (
                    <p>Your cart is empty.</p>
                ) : (
                    <div>
                        <ul>
                            {cartItems.map((item, index) => (
                                <li key={index}>
                                    <strong>{item.product.name}</strong>
                                    <ul>
                                        {Object.keys(item.selectedAttributes).map(attrId => (
                                            <li key={attrId}>
                                                <strong>{item.selectedAttributes[attrId].name}:</strong> {item.selectedAttributes[attrId].value}
                                            </li>
                                        ))}
                                    </ul>
                                    <button className="btn btn-danger btn-sm" onClick={() => onRemoveItem(index)}>Remove</button>
                                </li>
                            ))}
                        </ul>
                        <button className="btn btn-success" onClick={onMakeOrder}>Make Order</button>
                    </div>
                )}
            </div>
        </div>
    );
};

export default CartOverlay;