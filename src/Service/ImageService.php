<?php 

namespace App\Service;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageService{
   
    //injection de dependance depuis le constructeur car j'ai besoin de l'interface slugger
    public function __construct(private SluggerInterface $slugger){
        
    }

    public function CopyImage($name,$directory, $form){

        $imageFile= $form->get($name)->getData();



            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension(); // cela permet de donner des Id unique pour les photos

                // Move the file to the directory where articles are stored
                try {
                    $imageFile->move(
                        $directory,
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imageFilename' property to store the PDF file name
                // instead of its contents
                return $newFilename;
            }

    

    }

}

?>