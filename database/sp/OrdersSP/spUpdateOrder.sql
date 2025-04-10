CREATE PROCEDURE spUpdateOrder(
    IN order_id INT,
    IN new_status ENUM('send', 'making', 'pending'),
    IN new_note TEXT
)
BEGIN
    UPDATE orders
    SET 
        status = new_status,
        note = new_note,
        updated_at = NOW()
    WHERE id = order_id;
END;