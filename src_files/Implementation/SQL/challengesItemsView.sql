CREATE VIEW challenges_items AS
SELECT challenge_id, GROUP_CONCAT(item_name)
FROM challenges
INNER JOIN items_used
USING (challenge_id)
INNER JOIN sold_items
USING (item_sold_id)
INNER JOIN items
USING(item_id)
GROUP BY (challenge_id);
