<?php

namespace Padaviva\Chatbot\Model;

class Utils {
    
    
    protected $normalizedStrings = [
        'password' => ['pass','passphrase'],
        'hello' => ['hi','howdy','day','morning','evening'],
        'talk' => ['speak','discuss'],
        'you' => ['u'],
        'bot' => ['robot','script']
    ];
    
    protected $stopWords = ['and','or','good'];
    
    protected $urlInterface;
    
    public function __construct(\Magento\Framework\UrlInterface $urlInterface)
    {
        $this->urlInterface = $urlInterface;
    }

    public function normalize($text) {
        $text = strtolower($text); //lowercase
        $text = str_replace('/[^a-z0-9\-\']/','',$text); //remove punctuation
        $text = preg_replace('/\s\s+/', ' ', $text); //more than one space in a row
        
        //normalize synonyms
        $words = explode(' ',$text);

        foreach($words as &$word) {
            if(in_array($word,$this->stopWords)) {
                unset($word);
            }
        }
        $words = array_values($words);
        
        foreach($words as &$word) {
            foreach($this->normalizedStrings as $key => $values) {
                if(in_array($word,$values)) {
                    $word = $key;
                }
            }
        }
        
        
        $text = implode($words);
        
        
        return $text;
    }
    
    
    public function parseTags($message) {
        
        return preg_replace_callback('/\\{\\{([^{}]+)\}\\}/',
            function($matches) 
            {
                $key = $matches[1];
                if(strpos($key,'mageurl') === 0) {
                    $parts = explode('|', $key);
                    return "<a target='_blank' href='".$this->urlInterface->getUrl($parts[1])."'>".$parts[2].'</a>';
                }
            }
            , $message);
    }
}