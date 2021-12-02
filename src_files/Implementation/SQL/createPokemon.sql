CREATE TABLE pokemon (
    PRIMARY KEY (pokemon_id),
    pokemon_id      INT  NOT NULL AUTO_INCREMENT,
    pokemon_level   INT NOT NULL CHECK (pokemon_level >=1 AND pokemon_level <=100),
    trainer_id        INT NOT NULL,
    FOREIGN KEY (trainer_id) REFERENCES trainers(trainer_id),
    species_name     VARCHAR(32) NOT NULL,
    FOREIGN KEY (species_name) REFERENCES pokemon_species(species_name) ON DELETE RESTRICT
);