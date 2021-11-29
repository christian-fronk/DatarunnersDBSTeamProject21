CREATE VIEW hall_of_fame AS
SELECT trainer_id, challenge_id
FROM trainers
INNER JOIN challenges
USING (trainer_id)
WHERE challenge_progress_made = "5";