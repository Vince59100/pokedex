<?php

namespace App\Controller;

use App\Entity\Pokemon;
use App\Form\PokemonType;
use App\Repository\PokemonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/pokemon')]
class PokemonController extends AbstractController
{
    private $pokemonRepository;

    public function __construct(PokemonRepository $pokemonRepository)
    {
        $this->pokemonRepository = $pokemonRepository;
    }

    #[Route('/pokedex', name: 'pokedex')]
    public function pokedex(): Response {

        $pokemons = $this->pokemonRepository->getAll();

        return $this->render('pokemon/index.html.twig', [
            'pokemons' => $pokemons,
        ]);
    }

    #[Route('/pokemon/delete/{id}', name: 'pokemon_delete', methods:['POST'])]
    public function delete(Request $request, Pokemon $pokemon): RedirectResponse
    {
        $this->pokemonRepository->delete($pokemon);

        return $this->redirectToRoute('pokedex');
    }


    #[Route('/edit/{id}', name: 'pokemon_edit')]
    public function edit(Request $request, Pokemon $pokemon): Response
    {
        $form = $this->createForm(PokemonType::class, $pokemon);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->pokemonRepository->update($pokemon);
            return $this->redirectToRoute('pokedex');
        }

        return $this->render('pokemon/edit.html.twig', [
            'form' => $form->createView(),
            'pokemon' => $pokemon,
        ]);
    }


    #[Route('/add', name: 'pokemon_add')]
    public function add(Request $request): Response
    {
        $pokemon = new Pokemon(); 
        $form = $this->createForm(PokemonType::class, $pokemon);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->pokemonRepository->add($pokemon);
            return $this->redirectToRoute('pokedex');
        }

        return $this->render('pokemon/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
