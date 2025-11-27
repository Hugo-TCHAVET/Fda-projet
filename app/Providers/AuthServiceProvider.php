<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate pour accéder à la liste des demandes (secrétaire uniquement)
        Gate::define('view-liste-demandes', function ($user) {
            return $user->isSecretaire();
        });

        // Gate pour accéder aux demandes vérifiées (vérificateurs)
        Gate::define('view-demandes-verifiees', function ($user) {
            return $user->isVerificateur();
        });

        // Gate pour accéder aux demandes approuvées (vérificateurs)
        Gate::define('view-demandes-approuvees', function ($user) {
            return $user->isVerificateur();
        });

        // Gate pour accéder aux demandes suspendues (vérificateurs)
        Gate::define('view-demandes-suspendues', function ($user) {
            return $user->isVerificateur();
        });

        // Gate pour accéder au suivi des demandes (directeurs)
        Gate::define('view-suivi-demandes', function ($user) {
            return $user->isDirecteur();
        });

        // Gate pour accéder aux statistiques (vérificateurs et directeurs)
        Gate::define('view-statistiques', function ($user) {
            return $user->isVerificateur() || $user->isDirecteur();
        });

        // Gate pour accéder au post-appui (vérificateurs et directeurs)
        Gate::define('view-post-appui', function ($user) {
            return $user->isVerificateur() || $user->isDirecteur();
        });

        // Gate pour accéder aux dossiers clôturés (vérificateurs et directeurs)
        Gate::define('view-dossiers-clotures', function ($user) {
            return $user->isVerificateur() || $user->isDirecteur();
        });

        // Gate générique pour gérer les demandes (secrétaire + vérificateurs)
        Gate::define('manage-demandes', function ($user) {
            return $user->isSecretaire() || $user->isVerificateur();
        });

        // Gate pour les actions sensibles (budget, suspension, validations)
        Gate::define('process-demandes', function ($user) {
            return $user->isVerificateur();
        });

        //Gate pour voir les détails des demandes
        Gate::define('view-demande-details', function ($user) {
            return $user->isSecretaire() || $user->isVerificateur() || $user->isDirecteur();
        });

        //Gate pour voir le formulaire
        Gate::define('view-formulaire', function ($user) {
            return $user->isSecretaire();
        });
    }
}
