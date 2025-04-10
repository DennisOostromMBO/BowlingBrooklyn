DELIMITER //

CREATE PROCEDURE GetScores()
BEGIN
    SELECT * FROM scores;
END //

CREATE PROCEDURE AddScore(
    IN reservationId BIGINT,
    IN points INT,
    IN round INT,
    IN isActive BOOLEAN,
    IN note TEXT
)
BEGIN
    INSERT INTO scores (reservation_id, points, round, isactive, note, created_at, updated_at)
    VALUES (reservationId, points, round, isActive, note, NOW(), NOW());
END //

CREATE PROCEDURE UpdateScore(
    IN scoreId BIGINT,
    IN points INT,
    IN round INT,
    IN isActive BOOLEAN,
    IN note TEXT
)
BEGIN
    UPDATE scores
    SET points = points,
        round = round,
        isactive = isActive,
        note = note,
        updated_at = NOW()
    WHERE id = scoreId;
END //

CREATE PROCEDURE DeleteScore(
    IN scoreId BIGINT
)
BEGIN
    DELETE FROM scores WHERE id = scoreId;
END //

DELIMITER ;
