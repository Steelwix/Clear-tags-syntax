public function removeDuplicatedTagsInString(): array
    {
        $file = fopen('../value.csv', 'r');

    $tags = array();
        while (($results = fgetcsv($file)) !== false)
        {
            foreach ($results as $result){
                $tags[] = $result;
            }

        }

        fclose($file);
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

                    list($tags, $reversed_tags_count) = $this->updateTagsArray($tags, $tag, $lowTag);
                    break; //Relancement du foreach avec le nouvel array

                }
                if (preg_match('/[\&\,\/]/', $tag, $matches)) { //Les symboles / & et , sont remplacés par "et"
                    $clearTag = $this->dismantleSlashedTags($tag, $matches);
                    list($tags, $reversed_tags_count) = $this->updateTagsArray($tags, $tag, $clearTag);
                    break; //Relancement du foreach avec le nouvel array


                }
                if (preg_match('/\'/', $tag)) { // L'apostrophe est remplacé par un espace
                    $clearTag = $this->dismantleApostrophe($tag);
                    list($tags, $reversed_tags_count) = $this->updateTagsArray($tags, $tag, $clearTag);
                    break; //Relancement du foreach avec le nouvel array

                }

                $subTag = substr($tag, -1); //Detection de la dernière lettre du tag
                if($subTag === " "){ //Retire l'espace à la fin du tag si il y en a un
                    $clearTag = substr($tag, 0, -1);
                    list($tags, $reversed_tags_count) = $this->updateTagsArray($tags, $tag, $clearTag);
                    break; //Relancement du foreach avec le nouvel array
                }
                $update = $this->pluralChecker($tags, $tag, $subTag);
                if(is_array($update)){
                    list($tags, $reversed_tags_count) = $this->pluralChecker($tags, $tag, $subTag);
                    break; //Relancement du foreach avec le nouvel array
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
        $file = fopen('../output.csv', 'w');
    $export = array();
        foreach ($tags as $tag){
            $export[] = array($tag);
        }
        foreach ($export as $fields){
            fputcsv($file, $fields);
        }

        fclose($file);
        return $tags;
    }
    public function pluralChecker(array $array, string $string, string $subString){
        if ($subString === "s" || $subString === "x") { //Si la dernière lettre peut symboliser le pluriel
            $singular = substr($string, 0, -1);    // On définit une variable $singular qui représente notre tag au singulier


            if (in_array($singular, $array)) { //Si le tag au singulier existe dans l'array de la bdd
                $update = $this->updateTagsArray($array, $singular, $string);

            }
        } else { //Si la derniere lettre n'est pas synonyme de pluriel
            $plural = $string  . "s"; // On définit une variable $plural qui représente notre tag au pluriel
            if (in_array($plural, $array)) { //Si le tag au pluriel existe dans l'array de la bdd
                $update = $this->updateTagsArray($array, $plural, $string);
            }
        }
        if(isset($update)){
    return $update;
        }

    }
        public function dismantleSlashedTags($string, $matches): string
        {
            foreach ($matches as $match){ //Peu importe le symbole detecté, on le remplace par "et"
                switch($match){
                    case '/':
                        $string = str_replace('/', ' et ', $string);
                        break;
                    case '&':
                        $string = str_replace('&', 'et', $string);
                        break;
                    case ',':
                        $string = str_replace(',', ' et', $string);
                        break;
                }
            }

            return $string;
        }
        public function dismantleApostrophe($string): string
        {
            $clearString = str_replace('\'', ' ', $string);// Remplacement des apostrophes par un espace
            return $clearString;
        }
        public function supprimerAccents(string $string, bool $remove_special_char = true, ?string $replace_space = null, array $exceptions = []): string
        {
            $string = transliterator_transliterate('Any-Latin; Latin-ASCII;', $string);
            $string = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string); //Adaptation du format texte pour supprimer
            //les accents

            if ($remove_special_char) $string = $this->supprimerSpecialChar($string, $exceptions); //Suppression des symboles
            $string = preg_replace('/\s+/', ' ', $string); //Refactorisation des espaces de trop

            $string = trim($string);
            if ($replace_space !== null) $string = str_replace(' ', $replace_space, $string);

            return $string;
        }
        public function supprimerSpecialChar(string $string, array $exceptions = []): string //Suppression caractères spéciaux
        {
            $regex = '/[^\p{L}';

            foreach ($exceptions as $exception) {
                $regex .= '\\' . $exception;
            }

            $regex .= ']/u';

            return preg_replace($regex, '', $string);
        }
        public function removeCaps($string): string //Transformation des majuscules en minuscules
        {
            $string = strtolower($string);
            return $string;
        }
    public function updateTagsArray(array $array, string $oldValue, string $newValue): array{
        $keys = array_keys($array, $oldValue); //Detection du tag a modifier dans le tableau des tags
        foreach ($keys as $key => $value) {
            $array[$value] = $newValue; //Assignation de la nouvelle valeur
        }
        $array_count = array_count_values($array); //Rafraichissement des arrays
        asort($array_count);
        $reversed_array_count = array_reverse($array_count);
        $result[0] = $array; //La nouvelle valeur de $tags est stockée dans $result[0]
        $result[1] = $reversed_array_count;//La nouvelle valeur de reverses_tag_count est stockée dans $result[1]
        echo '<pre>', 'updating tags ', var_dump($array), '</pre>';
        return $result;

    }
