DROP DATABASE IF EXISTS pokemon_league;
CREATE DATABASE pokemon_league;
USE pokemon_league;

SET foreign_key_checks = 0;
SOURCE createTrainers.sql;

SOURCE createChallenges.sql;

SOURCE createPokemon.sql;

SOURCE createSoldItems.sql;

SOURCE createPokemonSpecies.sql;

SOURCE createPokemonTypes.sql;

SOURCE createPokemonSpeciesTypes.sql;

SOURCE createItems.sql;

SOURCE createItemsUsed.sql;

SOURCE createPokemonParticipants.sql;

SOURCE createEliteFour.sql;

SET foreign_key_checks = 1;