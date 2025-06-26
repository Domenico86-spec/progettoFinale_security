## Rate limiter mancante

### Scenario:
Creare ed eseguire uno script (es. in bash con curl) che lancia moltissime richieste sulla stessa rotta con il pericolo di un denial of service

### Mitigazione:
- Rate limiter su /careers/submit
- Rate limiter su /article/search
- Rate limiter globale

## Logging mancante per operazioni critiche

### Scenario:
Sui tentativi precedenti di DoS non si può risalire al colpevole violando il principiio di accountability e no repudiation

### Mitigazione:
Log di:
- login/registrazione/logout
- creazione/modifica/eliminazione articolo
- assegnazione/cambi di ruolo

## Operazioni critiche in post e non in get

### Scenario: 
Ci si espone a possibili attacchi CSRF portando in questo caso ad una vertical escalation of privileges.
Provare un attacco csrf creando un piccolo server php che visualizzi una pagina html in cui in background scatta una chiamata ajax ad una rotta potenzialmente critica e non protetta (es. /admin/{user}/set-admin). Partendo dal browser dell'utente è possibile che l'azione vada in porto in quanto l'utente ha i privilegi adeguati.

### Mitigazione
Cambiare da get a post, facendo i dovuti controlli

## Uso non corretto di fillable nei modelli

### Scenario 
Un utente malevolo può provare a indovinare campi tipici di ruoli utente tipo isAdmin, is_admin etc.. alterando il form dal browser 

### Mitigazione
Nella proprietà fillable del modello in questione inserire tutti solo i campi gestiti nel form

## ssrf attack per api delle news

### Scenario
Esiste la funzionalità di suggerimento news recenti in fase di scrittura dell'articolo per prendere ispirazione. E' presente un menu a scelta facilmente alterabile da ispeziona elemento. L'utente malintenzionato con un minimo di conoscenza del sistema cambia l'url e prova a far lanciare al server una richiesta che lui non sarebbe autorizzato.
Per esempio il server recupera dei dati sugli utenti da un altro server in esecuzione sulla porta 8001. 


### Mitigazione
Rimodellare la funzionalità in modo tale da non poter lasciare spazio di modifica dell'url da parte di utenti malevoli. Implementare o migliorare la validazione delgli input.

https://newsapi.org/docs/endpoints/top-headlines
NewsAPI - api key 5fbe92849d5648eabcbe072a1cf91473

## Stored XSS Attack

### Scenario
Durante la creazione di un articlo si può manomettere il body della richiesta con un tool tipo burpsuite in modalità proxy in modo da evitare l'auto escape eseguito dall'editor stesso e far arrivare alla funzionalità di creazione articolo uno script malevelo nel testo.
Questo script verra memorizzato ed eseguito quando un utente visualizza l'articolo infettato.
Supponiamo che ci sia una misconfiguration a livello di CORS (config/cors.php) che quindi permetta richieste da domini esterni, utile quando frontend e backend sono separati ma se non opportunamente configurato risulta essere un grave problema.

### Mitigazione
Creare un meccanismo che filtri il testo prima di salvarlo e per essere sicuri anche in fase di visualizzazione dell'articolo.

# progettoFinale_security


1° Challenge:
- Creato e sviluppato un codice che simuli un attacco al sito, lo stesso attacco è andato a buon fine in quanto si è registrato un rallentamento generale del sito per poi arrivare a un blocco completo.
Per fare ciò abbiamo inserito nel terminale il comando "chmod +x dos.sh ./dos.sh" che provoca un rallentamento del caricamento del sito.
- Abbiamo mitigato l'attacco informatico inserendo la funzione "RateLimiter" sia per la stringa 'global' che per la stringa 'articlesearch'.
Poi abbiamo incluso il blocco temporneo ID con la funzione "response function () 
        return response('Troppe richieste di ricerca.', 429);"


2° Challenge:
-  set-Admin 
-  set-writer 
-  set-revisor 
Abbiamo modificato le rotte 'get' in 'rotte 'patch'  Esempio: Route::patch('/admin/{user}/set-admin', [AdminController::class, 'setAdmin'])->name('admin.setAdmin');

3° Challenge:

Abbiamo implementato i "Log"  per le seguenti operazioni che possono essere oggetto di attacco informatico:

Inseriti i Log per il login e la password all'interno di Fortify.

 Fortify::loginView(function (Request $request) {

            Log::info('Login effettuato', [
                        'email' => $request->email,
                        'ip' => request()->ip(),
                        'timestamp' => now()->toDateTimeString(),

                    ]);
            return view('auth.login');

            

        });

        Fortify::registerView(function (Request $request) {

            Log::info('Registrazione effettuata', [
                        'email' => $request->email,
                        'ip' => request()->ip(),
                        'timestamp' => now()->toDateTimeString(),
            ]);
            return view('auth.register');
        });

Implementato il "LogUser" , "LogUserRegistered" e il "LogUserlogout" all'interno di "EventServiceProvider".
Implementato la funzione: public function handle( Logout $event): void
    {
         Log::debug('Evento Logout ricevuto');

        Log::info('Logout effettuato', [
            'email' => $event->user->email,
            'ip' => request()->ip(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }; Questa funzione è stata inserita all'interno di "LogUserLOgOut".

Implementato il "Log" per l'articolo creato, l'articolo modificato e l'articolo da cancellare all'interno della funzione "ArticleController".
Implementato il "Loginfo" per il ruolo di "Admin" all'interno della funzione:
 - public function setAdmin(User $user).

Il "Loginfo" per il ruolo di "revisor" all'interno della funzione:
- public function setRevisor(User $user).

Il "Loginfo" per il ruolo di "writer" all'interno della funzione:
- public function setWriter(User $user).
   

