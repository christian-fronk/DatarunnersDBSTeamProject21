CREATE TABLE items (
    PRIMARY KEY (item_id),
    item_id      INT  NOT NULL AUTO_INCREMENT,
    item_name    VARCHAR(32) NOT NULL,
    item_description   VARCHAR(64) NOT NULL,
    item_stock       INT NOT NULL,
    item_cost        INT NOT NULL,
    isActiveItem     BOOLEAN
);