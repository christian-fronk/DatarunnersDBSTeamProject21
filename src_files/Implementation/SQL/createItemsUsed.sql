CREATE TABLE items_used (
    PRIMARY KEY (item_sold_id,challenge_id),
    item_sold_id      INT  NOT NULL,
    FOREIGN KEY (item_sold_id) REFERENCES sold_items(item_sold_id) ON DELETE RESTRICT,
    challenge_id      INT NOT NULL,
    FOREIGN KEY (challenge_id) REFERENCES challenges(challenge_id) ON DELETE RESTRICT
    
);