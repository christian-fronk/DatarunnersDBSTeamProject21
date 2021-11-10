SELECT * 
FROM items_used 
    WHERE item_sold_id = ?
        AND challenge_id = ?;