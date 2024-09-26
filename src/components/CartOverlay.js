// src/components/CartOverlay.js
import React from 'react';

const CartOverlay = ({ cartItems, onClose, onRemoveItem, onMakeOrder }) => {
    console.log('Rendering CartOverlay with items:', cartItems);

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
                            {cartItems.map((item, index) => {
                                console.log('Rendering cart item:', item);
                                return (
                                    <li key={index}>
                                        <strong>{item.product?.name || 'Unknown Product'}</strong>
                                        <ul>
                                            {Object.keys(item.selectedAttributes || {}).map(attrId => {
                                                const attribute = item.selectedAttributes[attrId];
                                                console.log('Rendering attribute:', attribute);
                                                return (
                                                    <li key={attrId}>
                                                        <strong>{attribute?.name || 'Unknown Attribute'}:</strong> {attribute?.value || 'Unknown Value'}
                                                    </li>
                                                );
                                            })}
                                        </ul>
                                        <button className="btn btn-danger btn-sm" onClick={() => onRemoveItem(index)}>Remove</button>
                                    </li>
                                );
                            })}
                        </ul>
                        <button className="btn btn-success" onClick={onMakeOrder}>Make Order</button>
                    </div>
                )}
            </div>
        </div>
    );
};

export default CartOverlay;