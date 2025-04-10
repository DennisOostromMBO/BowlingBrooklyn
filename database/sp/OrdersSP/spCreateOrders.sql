CREATE PROCEDURE spCreateOrder(
    IN bowling_alleyid INT,
    IN product ENUM('Pizza', 'Nachos', 'Drinks Package', 'Burger', 'VIP Package', 'Wings', 'Fries', 'Snack Platter', 'Premium Drinks', 'Kids Menu'),
    IN status ENUM('send', 'making', 'pending'),
    IN note TEXT
)
BEGIN
    DECLARE price DECIMAL(8, 2);

    -- Determine the price based on the product
    SET price = CASE 
        WHEN product = 'Pizza' THEN 10.00
        WHEN product = 'Nachos' THEN 8.00
        WHEN product = 'Drinks Package' THEN 15.00
        WHEN product = 'Burger' THEN 12.00
        WHEN product = 'VIP Package' THEN 50.00
        WHEN product = 'Wings' THEN 9.00
        WHEN product = 'Fries' THEN 5.00
        WHEN product = 'Snack Platter' THEN 20.00
        WHEN product = 'Premium Drinks' THEN 25.00
        WHEN product = 'Kids Menu' THEN 7.00
        ELSE 0.00 
    END;

    -- Insert the order into the orders table
    INSERT INTO orders (
        bowling_alleyid,
        product,
        status,
        price,
        total_price,
        isactive,
        note,
        created_at,
        updated_at
    )
    VALUES (
        bowling_alleyid,
        product,
        status,
        price,
        price, -- Assuming total_price is initially the same as price
        TRUE, -- Automatically set isactive to TRUE
        note,
        NOW(),
        NOW()
    );
END;