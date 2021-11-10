-- instead of age use the date of birth might need to fix ER diagram (call it trainer_date_of_birth)
UPDATE trainers
   SET trainer_dob = ?
 WHERE trainer_id = ?;