CREATE VIEW [Hall of Fame] AS
SELECT trainer_id, challenge_id
FROM trainers
INNER JOIN challenges
ON trainer_id
WHERE challenge_progress_made = '5';