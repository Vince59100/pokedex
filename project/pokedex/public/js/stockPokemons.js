let allPokemons = [];
let allId = [];
let pokemonsData = [];

//Nombre de pokemons
let maxPokemons = 151;

fetch(`https://pokeapi.co/api/v2/pokemon?limit=${maxPokemons}&offset=0`)
    .then(response => response.json())
    .then(data => {
        allPokemons = data.results;

        let promises = allPokemons.map(pokemon => {
            const pokemonID = pokemon.url.split("/")[6];
            const newPokemonData = {
                idPokemon: pokemonID,
                nom: pokemon.name,
                description: "",
                imagePokedex: "",
                imageDetail: "",
            };

            // Récupération des images et des descriptions
            return Promise.all([
                recupererDescription(pokemonID, newPokemonData),
                recupererImages(pokemonID, newPokemonData)
            ]).then(() => {
                pokemonsData.push(newPokemonData);
            });
        });

        return Promise.all(promises);
    })
    .then(() => {
        console.log(pokemonsData);
        sauvegardePokemons(pokemonsData);
    })
    .catch(error => {
        console.error('Erreur lors de la récupération des Pokémon:', error);
    });

function recupererDescription(idPokemon, pokemonData) {
    return fetch(`https://pokeapi.co/api/v2/pokemon-species/${idPokemon}`)
        .then(response => response.json())
        .then(data => {
            const entry = data.flavor_text_entries.find(entry => entry.language.name === "fr");
            if (entry) {
                pokemonData.description = entry.flavor_text.replace(/\n/g, ' ');
            }
        })
        .catch(error => {
            console.error('Erreur lors de la récupération de la description:', error);
        });
}

function recupererImages(idPokemon, pokemonData) {
    return fetch(`https://pokeapi.co/api/v2/pokemon/${idPokemon}`)
        .then(response => response.json())
        .then(data => {
            pokemonData.imagePokedex = data.sprites.front_default;
            pokemonData.imageDetail = data.sprites.other.dream_world.front_default;
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des images:', error);
        });
}

function redirect(){
    console.log("redirection");
    window.location.replace("http://localhost:9000/pokemon/pokedex");
}

function sauvegardePokemons(pokemons) {
    console.log("Sauvegarde des Pokémon");

    const postPromises = pokemons.map(pokemon => {
        return fetch('http://localhost:9000/api/pokemon', {
            method: 'POST',
            headers: { 'Content-Type': 'application/ld+json' },
            body: JSON.stringify({
                id: parseInt(pokemon.idPokemon),
                nom: pokemon.nom,
                description: pokemon.description,
                imagePokedex: pokemon.imagePokedex,
                imageDetail: pokemon.imageDetail,
                idPokemon: parseInt(pokemon.idPokemon)
            })
        })
        .then(response => response.json());
    });

    Promise.all(postPromises)
        .then(results => {
            console.log('Résultats des envois :', results);
            redirect();
        })
        .catch(err => console.error('Erreur lors de la sauvegarde des Pokémon:', err));
}




