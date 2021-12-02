CREATE TABLE pokemon_species_types (
    PRIMARY KEY (species_name,pokemon_type_name),
    species_name  VARCHAR(32) NOT NULL,
    FOREIGN KEY (species_name) REFERENCES species(species_name) ON DELETE RESTRICT,
    pokemon_type_name VARCHAR(32) NOT NULL,
     FOREIGN KEY (pokemon_type_name) REFERENCES pokemon_types(pokemon_type_name) ON DELETE RESTRICT
);