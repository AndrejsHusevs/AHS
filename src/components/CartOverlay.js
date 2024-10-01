import React from 'react';

const CartOverlay = ({ cartItems, onClose, onRemoveItem, onMakeOrder, onIncreaseQuantity, onDecreaseQuantity }) => {
        
    //console.log('Rendering CartOverlay with items: ', cartItems);    

    const totalPrice = cartItems.reduce((total, item) => total + item.product.price_amount * item.quantity, 0).toFixed(2);
    const totalItemCount = cartItems.reduce((total, item) => total + item.quantity, 0);

    return (
        <div className="cart-overlay-wrapper">
            <div className="cart-overlay-background" onClick={onClose}></div>
            <div className="cart-overlay">
                <div className="cart-content">
                    <p>My Bag: {totalItemCount} {totalItemCount === 1 ? 'item' : 'items'}
                    </p>
                    {cartItems.length === 0 ? (
                        <p>Your cart is empty.</p>
                    ) : (
                        <div>
                            <ul className="cart-items-list">
                                {cartItems.map((item, index) => {
                                    console.log('Rendering cart item:', item);
                                    return (
                                        <li key={index} className="cart-item-row">
                                            <div className="cart-item-column">
                                                <strong>{item.product?.name || 'Unknown Product'}</strong>
                                                <p>{item.product.price_currency_symbol} {item.product.price_amount}</p>                                                
                                                    {Object.keys(item.selectedAttributes || {}).map(attrId => {
                                                        console.log('(CartOverlay) Item attribute:', attrId, item.selectedAttributes[attrId]);
                                                           
                                                        const attribute = item.selectedAttributes[attrId];                                                        
                                                        return (
                                                        <div className="">
                                                            <p>{attribute?.name || 'Unknown Attribute'}:</p>
                                                            <div>
                                                                {attribute.allPossibleAttributeItems.map((attrItem, idx) => {
                                                                    const isSwatch = attribute.type === 'swatch';
                                                                    const backgroundColor = isSwatch ? attrItem.value : '';
                                                                    const isValidColor = /^#[0-9A-F]{6}$/i.test(backgroundColor) || /^(rgb|hsl)a?\((\d{1,3}%?,\s?){3,4}\)$/i.test(backgroundColor);

                                                                    if (isSwatch && !isValidColor) {
                                                                        console.warn(`Invalid color value: ${backgroundColor}`);
                                                                    }
                                                                    console.log('attrItem:', attrItem, 'attribute:', attribute);
                                                                    return (
                                                                        <span
                                                                            key={idx}
                                                                            className={`attribute-item-in-cart ${attrItem.id === attribute.value ? 'selected-item-in-cart' : ''}`}
                                                                            style={isSwatch && isValidColor ? { backgroundColor, width: '24px', height: '24px', display: 'inline-block', margin: '2px' } : { display: 'inline-block', margin: '2px' }}
                                                                        >
                                                                            {isSwatch ? '' : attrItem.display_value}
                                                                        </span>
                                                                    );
                                                                })}
                                                            </div>
                                                        </div>                                                        
                                                        );
                                                    })}                                                
                                            </div>
                                            <div className="cart-item-column quantity-column">
                                                <button className="btn btn-secondary btn-sm" onClick={() => onIncreaseQuantity(index)}>+</button>
                                                <br/>
                                                <div class="quantity-in-cart">{item.quantity}</div>
                                                <br/>
                                                <button className="btn btn-secondary btn-sm" onClick={() => onDecreaseQuantity(index)}>-</button>
                                            </div>
                                            <div className="cart-item-column">
                                                <img src={item.product.gallery[0]} alt={item.product?.name || 'Product Image'} className="cart-item-image" />
                                            </div>                                            
                                        </li>
                                    );
                                })}
                            </ul>
                            <div className="cart-total">
                                <strong>Total</strong>
                                <strong className="total-price">{totalPrice}</strong>
                            </div>
                            <button className="btn btn-success" onClick={onMakeOrder}>PLACE ORDER</button>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
};

export default CartOverlay;