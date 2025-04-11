CREATE PROCEDURE spDeleteOrder(
    IN order_id INT
)
BEGIN
    DELETE FROM orders
    WHERE id = order_id;
END;