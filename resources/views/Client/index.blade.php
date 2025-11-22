@extends('Commun.Client')

@section('contenu')

<!-- Import de la police Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<!-- Tailwind CSS (via CDN pour garantir que les classes fonctionnent immédiatement) -->
<script src="https://cdn.tailwindcss.com"></script>

<style>
  /* Configuration Tailwind personnalisée pour correspondre aux couleurs demandées */
  /* On écrase ou complète les styles si nécessaire */
  body {
    font-family: 'Poppins', sans-serif;
    overflow-x: hidden;
  }

  /* Animation personnalisée pour le curseur Typed si non incluse */
  .typed-cursor {
    font-size: 30px;
    color: greenyellow;
    /* amber-500 */
  }
</style>

<main id="main" class="!ml-0 !pl-0 relative w-full h-screen overflow-hidden font-sans">

  <!-- 1. Image de fond immersive avec Overlay -->
  <div class="absolute inset-0 z-0">
    <!-- Image d'artisanat -->
    <img
      src="Client/assets/img/fda.jpg"
      alt="Artisanat Background"
      class="w-full  object-cover object-center">
    <!-- Le gradient permet de rendre le texte lisible (Nuances de vert foncé/slate au lieu du noir pur si désiré, ici Slate par défaut du code fourni) -->
    <div class="absolute inset-0 bg-gradient-to-r from-slate-900/95 via-slate-900/80 to-slate-900/40"></div>
  </div>

  <!-- 2. Contenu Principal -->
  <section class="relative z-10 flex flex-col justify-center h-full px-6 mx-auto max-w-7xl">

    <div class="max-w-3xl pl-10" data-aos="fade-up" data-aos-duration="1000">

      <!-- Badge / Petit titre -->
      <span class="inline-block py-1 px-3 rounded-full  text-[#198754] border border-amber-500/30 text-sm font-semibold tracking-wider mb-6">
        RÉPUBLIQUE DU BÉNIN
      </span>

      <!-- Titre Principal -->
      <h1 class="text-5xl md:text-7xl font-extrabold text-white leading-tight mb-6">
        Fonds de Développement <br />
        de <span class="text-[#198754]">l’Artisanat</span>
      </h1>

      <!-- Sous-titre avec l'effet Typed.js -->
      <p class="text-xl md:text-2xl text-gray-300 font-light mb-8 h-16 md:h-auto">
        Le FDA vous assiste sous trois formes : <br class="md:hidden" />
        <span class="font-bold text-white border-b-4 border-[#198754] typed"
          data-typed-items="Formation., Promotion., Appui Financier."></span>
      </p>

      <!-- Boutons d'action (Call to Action) -->
      <div class="flex flex-col sm:flex-row gap-4 mt-8">
        <a href="{{ route('client.formulaire') }}"
          class="group flex items-center justify-center px-8 py-4 text-lg font-bold text-slate-900 bg-[#198754] rounded-lg shadow-lg hover:bg-amber-400 transition-all duration-300 hover:-translate-y-1">
          <span>Demander un appui</span>
          <!-- Petite flèche qui bouge au survol -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
          </svg>
        </a>

        <a href="{{ route('login') }}"
          class="flex items-center justify-center px-8 py-4 text-lg font-medium text-white border border-gray-600 rounded-lg hover:bg-white/10 hover:border-white transition-all duration-300">
          Se connecter
        </a>
      </div>

      <!-- Réseaux Sociaux (Style minimaliste) -->
      <div class="mt-12 flex items-center gap-6 text-gray-400">
        <span class="text-sm uppercase tracking-widest opacity-60">Suivez-nous</span>
        <div class="h-px w-12 bg-gray-700"></div> <!-- Ligne séparatrice -->
        <div class="social-links flex gap-4 text-2xl">
          <a href="#" class="hover:text-amber-500 transition-colors transform hover:scale-110"><i class="bx bxl-twitter"></i></a>
          <a href="#" class="hover:text-amber-500 transition-colors transform hover:scale-110"><i class="bx bxl-facebook"></i></a>
          <a href="#" class="hover:text-amber-500 transition-colors transform hover:scale-110"><i class="bx bxl-instagram"></i></a>
          <a href="#" class="hover:text-amber-500 transition-colors transform hover:scale-110"><i class="bx bxl-linkedin"></i></a>
        </div>
      </div>

    </div>
  </section>

</main>

@endsection