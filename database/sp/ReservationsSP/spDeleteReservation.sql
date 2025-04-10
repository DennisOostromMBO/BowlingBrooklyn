CREATE PROCEDURE spDeleteReservation(IN reservation_id INT)
BEGIN
    DELETE FROM reservations WHERE id = reservation_id;
END;
