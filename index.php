 public function removeDuplicatedTagsInString(): Response
        {

            $tags = array("couteau", "champagnes", "champagne", "champane", "voiture", "couteaux", "couteaux", "champagne", "élèctrique", "Chocolat / bonbons");
            echo '<pre>' , var_dump($tags) , '</pre>';
            $tags_count = array_count_values($tags); //Classer les tags par fréquence
            asort($tags_count);
            $reversed_tags_count = array_reverse($tags_count);
            echo '<pre>' , var_dump($reversed_tags_count) , '</pre>';
            $clearTags = false;

            while ($clearTags === false){
                end($reversed_tags_count);
                $lastElement = key($reversed_tags_count);
                foreach ($reversed_tags_count as $tag => $count) { //Foreach qui va vérifier les tags dans l'odre de fréquence
                    echo '<pre>' , "starting foreach" , '</pre>';
                    $subTag = substr($tag, -1);
                    if ($subTag === "s" || $subTag === "x") { //Si la dernière lettre peut symboliser le pluriel
                        echo '<pre>' , " plural detected in " . $tag , '</pre>';
                        $singular = substr($tag, 0, -1);    // On définit une variable $singular qui représente notre tag au singulier
                        echo '<pre>' , "singular is :" . $singular , '</pre>';

                        if (in_array($singular, $tags)) { //Si le tag au singulier existe dans l'array de la bdd
                            echo '<pre>' , $singular . " detected in tags " , '</pre>';
                            $keys = array_keys($tags, $singular);
                            foreach ($keys as $key => $value) {
                                $tags[$value] = $tag; //On le remplace par sa version au pluriel, qui est plus fréquente.
                                //Note : on utilise pas strtr_replace car la méthode va bouclier en remplacant "maisons" par "maisonss"
                            }
                            $tags_count = array_count_values($tags); //Rafraichissement des arrays
                            asort($tags_count);
                            $reversed_tags_count = array_reverse($tags_count);
                            echo '<pre>' , var_dump($tags) , '</pre>';
                            break; //Relancement du foreach avec le nouvel array

                        }
                    } else { //Si la derniere lettre n'est pas synonyme de pluriel
                        echo '<pre>' , " no plural " . $tag , '</pre>';
                        $plural = $tag  . "s";// On définit une variable $plural qui représente notre tag au pluriel
                        echo '<pre>' , "plural is :" . $plural , '</pre>';
                        if (in_array($plural, $tags)) { //Si le tag au pluriel existe dans l'array de la bdd
                            echo '<pre>' , $plural . " detected in tags " , '</pre>';
                            $keys = array_keys($tags, $plural);
                            foreach ($keys as $key => $value){
                                $tags[$value] = $tag; //On le remplace par sa version au singulier, qui est plus fréquente
                            }

                            $tags_count = array_count_values($tags);//Rafraichissement des arrays
                            asort($tags_count);
                            $reversed_tags_count = array_reverse($tags_count);
                            echo '<pre>' , var_dump($tags) , '</pre>';
                            break; //Relancement du foreach avec le nouvel array
                        }
                    }
                    if(preg_match('/\//', $tag)){
                        $key = array_keys($tags, $tag);
                        $slashCleared = $this->dismantleSlashedTags($tag);
                        $tags[$key[0]] = $slashCleared[0];
                        $tags[] = $slashCleared[1];
                        $tags_count = array_count_values($tags);//Rafraichissement des arrays
                        asort($tags_count);
                        $reversed_tags_count = array_reverse($tags_count);
                        echo '<pre>' , var_dump($tags) , '</pre>';
                        // break; //Relancement du foreach avec le nouvel array

                    }
                        $lowTag = $this->removeCaps($tag);
                        $clearTag = $this->supprimerAccents($lowTag, true, null, ['(', ')']);
                        $key = array_keys($tags, $tag);
                    echo '<pre>' , var_dump($clearTag) , '</pre>';
                        $tags[$key[0]] = $clearTag;
                if($tag == $lastElement){
                    $clearTags = true;
                }}}

            die();
            return $this->render('back_test_stat/script.html.twig');
        }
        public function dismantleSlashedTags($string): array {
            $splitedTags = explode("/", $string);
            return $splitedTags;
        }
        public function supprimerAccents(string $string, bool $remove_special_char = true, ?string $replace_space = null, array $exceptions = []): string
        {
            $string = transliterator_transliterate('Any-Latin; Latin-ASCII;', $string);
            $string = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);

            if($remove_special_char) $string = $this->supprimerSpecialChar($string, $exceptions);
            $string = preg_replace('/\s+/', ' ', $string);

            $string = trim($string);
            if($replace_space !== null) $string = str_replace(' ', $replace_space, $string);

            return $string;
        }
        public function supprimerSpecialChar(string $string, array $exceptions = []): string
        {
            $regex = '/[^\p{L}';

            foreach($exceptions as $exception)
            {
                $regex .= '\\'.$exception;
            }

            $regex .= ']/u';

            return preg_replace($regex, '', $string);
        }
        public function removeCaps($string): string
        {
            $string = strtolower($string);
            return $string;
        }
