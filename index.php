   public function removeDuplicatedTagsInString(): Response
    {

        $tags = array("couteau", "champagnes", "champagne", "champane", "voiture", "couteaux", "couteaux", "champagne", "élèctrique", "Chocolat / bonbons");
        echo '<pre>', var_dump($tags), '</pre>';
        $tags_count = array_count_values($tags); //Classer les tags par fréquence
        asort($tags_count);
        $reversed_tags_count = array_reverse($tags_count);
        echo '<pre>', var_dump($reversed_tags_count), '</pre>';
        $clearTags = false;

        while ($clearTags === false) {
            end($reversed_tags_count); //Identification du dernier tag de l'array
            $lastElement = key($reversed_tags_count);
            echo '<pre>', "starting foreach", '</pre>';
            foreach ($reversed_tags_count as $tag => $count) {

                //Foreach qui va vérifier les tags dans l'odre de fréquence

                if(preg_match('/[A-Z]/', $tag)){
                    $lowTag = $this->removeCaps($tag); //Retire les uppercase

                    $update = $this->updateTagsArray($tags, $tag, $lowTag);
                    $tags = $update[0];
                    $reversed_tags_count = $update[1];
                    break; //Relancement du foreach avec le nouvel array

                }
                if (preg_match('/[\&\,\/]/', $tag, $matches)) { //Les symboles / & et , sont remplacés par "et"
                    $clearTag = $this->dismantleSlashedTags($tag, $matches);
                    $update = $this->updateTagsArray($tags, $tag, $clearTag);
                    $tags = $update[0];
                    $reversed_tags_count = $update[1];
                    break; //Relancement du foreach avec le nouvel array


                }
                if (preg_match('/\'/', $tag)) { // L'apostrophe est remplacé par un espace
                    $clearTag = $this->dismanteApostrophe($tag);
                    $update = $this->updateTagsArray($tags, $tag, $clearTag);
                    $tags = $update[0];
                    $reversed_tags_count = $update[1];
                    break; //Relancement du foreach avec le nouvel array

                }
                $this->pluralChecker($tags, $tag);
                $subTag = substr($tag, -1); //Detection de la dernière lettre du tag
                if($subTag === " "){ //Retire l'espace à la fin du tag si il y en a un
                    $clearTag = substr($tag, 0, -1);
                    $update = $this->updateTagsArray($tags, $tag, $clearTag);
                    $tags = $update[0];
                    $reversed_tags_count = $update[1];
                    break; //Relancement du foreach avec le nouvel array
                }
                if ($subTag === "s" || $subTag === "x") { //Si la dernière lettre peut symboliser le pluriel

                    $singular = substr($tag, 0, -1);    // On définit une variable $singular qui représente notre tag au singulier


                    if (in_array($singular, $tags)) { //Si le tag au singulier existe dans l'array de la bdd
                        $update = $this->updateTagsArray($tags, $singular, $tag);
                        $tags = $update[0];
                        $reversed_tags_count = $update[1];
                        break; //Relancement du foreach avec le nouvel array

                    }
                } else { //Si la derniere lettre n'est pas synonyme de pluriel
                    $plural = $tag  . "s"; // On définit une variable $plural qui représente notre tag au pluriel
                    if (in_array($plural, $tags)) { //Si le tag au pluriel existe dans l'array de la bdd
                        $update = $this->updateTagsArray($tags, $plural, $tag);
                        $tags = $update[0];
                        $reversed_tags_count = $update[1];
                        break; //Relancement du foreach avec le nouvel array
                    }
                }


                $clearTag = $this->supprimerAccents($tag, true, null, ['(', ')', ' ', '-']); //Retire les symboles
                $key = array_keys($tags, $tag); //Remplace le tag d'origine par le tag formaté
                $tags[$key[0]] = $clearTag;
                if ($tag == $lastElement) { //Si le tag analysé est le dernier du tableau, alors on arrête le script
                    echo '<pre>', 'tags are ready to go : ',var_dump($tags), '</pre>';
                    $clearTags = true;
                }
            }
        }

        die();
    }
    public function pluralChecker(array $array, string $string){

    }
        public function dismantleSlashedTags($string, $matches): string
        {
//            foreach ($matches in $match){
//            $splitedTags = explode($match, $string);
//            //check singular and plural
//        }

            $clearString = str_replace('/', ' et ', $string);
            $fullClearString = str_replace('&', 'et', $clearString);
            $megaClearString = str_replace(',', ' et', $fullClearString);
            return $megaClearString;
        }
        public function dismanteApostrophe($string): string
        {
            $clearString = str_replace('\'', ' ', $string);
            return $clearString;
        }
        public function supprimerAccents(string $string, bool $remove_special_char = true, ?string $replace_space = null, array $exceptions = []): string
        {
            $string = transliterator_transliterate('Any-Latin; Latin-ASCII;', $string);
            $string = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);

            if ($remove_special_char) $string = $this->supprimerSpecialChar($string, $exceptions);
            $string = preg_replace('/\s+/', ' ', $string);

            $string = trim($string);
            if ($replace_space !== null) $string = str_replace(' ', $replace_space, $string);

            return $string;
        }
        public function supprimerSpecialChar(string $string, array $exceptions = []): string
        {
            $regex = '/[^\p{L}';

            foreach ($exceptions as $exception) {
                $regex .= '\\' . $exception;
            }

            $regex .= ']/u';

            return preg_replace($regex, '', $string);
        }
        public function removeCaps($string): string
        {
            $string = strtolower($string);
            return $string;
        }
    public function updateTagsArray(array $array, string $oldValue, string $newValue): array{
        $keys = array_keys($array, $oldValue);
        foreach ($keys as $key => $value) {
            $array[$value] = $newValue;
        }
        $array_count = array_count_values($array); //Rafraichissement des arrays
        asort($array_count);
        $reversed_array_count = array_reverse($array_count);
        $result[0] = $array;
        $result[1] = $reversed_array_count;
        ;echo '<pre>', 'updating tags ', var_dump($array), '</pre>';
        return $result;

    }
