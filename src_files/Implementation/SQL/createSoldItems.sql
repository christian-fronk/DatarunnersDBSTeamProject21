CREATE TABLE sold_items (
    PRIMARY KEY (item_sold_id),
    item_sold_id      INT  NOT NULL AUTO_INCREMENT,
    item_id    INT  NOT NULL,
    FOREIGN KEY (item_id) REFERENCES items(item_id),
    trainer_id INT NOT NULL,
    FOREIGN KEY (trainer_id) REFERENCES trainers(trainer_id)
);