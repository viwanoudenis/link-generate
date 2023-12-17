<?php

namespace App\Controller;

use App\Entity\Attesstation;
use App\Entity\AttesstationContent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
class GenerationController extends AbstractController
{
    #[Route('/generation', name: 'app_generation')]
    public function index(EntityManagerInterface $entityManager,): Response
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        /* Note: any element you append to a document must reside inside of a Section. */

        // Adding an empty Section to the document...()
        $at= $entityManager->getRepository(AttesstationContent::class)->findBy(['attestation'=>1],["priority"=>'ASC']);
        
     
        $section = $phpWord->addSection(['marginTop' => 600]);
        $section->addImage(
            '/home/alass/PERSO/link-generate/src/Controller/Image1.png',
            array(
                'width'         => 450,
                'height'        => 84,
                'marginTop'     => -100,
                'marginLeft'    => -1,
                'wrappingStyle' => 'behind'
            )
        );
        
        foreach($at as $d)
        {
            if($d->getLabelle() == "modules")
            {
                $module = explode('"',$d->getModules());
                
                foreach($module as $m)
                {
                   $section->addCheckBox('module',$m,json_decode($d->getFontStyle(),true));
                }
            }
            if($d->getLabelle() == "data")
            {
                
                $section->addText(
                   "Nom : <br/>Prénom : <br/>Né(e) le : <br/>Lieu de naissance : <br/>Adresse : <br/><br/><br/>Société immatriculée au R.C.S : <br/>Adresse du siège : <br/><br/><br/>No d’identification : <br/>
                    ",
                    json_decode($d->getFontStyle(),true)
                );
                
            }

            $section->addText(
                $d->getText(),
                json_decode($d->getFontStyle(),true)
            );

        }



        // Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(uniqid().'.docx');

        return $this->render('generation/index.html.twig', [
            'controller_name' => 'GenerationController',
        ]);
    }
}
