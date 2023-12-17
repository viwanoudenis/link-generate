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
        
     
        $nom = "xxxxxxxxx";
        $prenom = "xxxxxxxxx";
        $date = "xxxxxxxxx";
        $lieu = "xxxxxxxxx";
        $adresse = "xxxxxxxxx";
        $societe = "xxxxxxxxx";
        $siege = "xxxxxxxxx";
        $no = "xxxxxxxxx";
        $section = $phpWord->addSection(['marginTop' => 600]);
        $section->getStyle()->setPageNumberingStart(1);
        $section->addImage(
            dirname(__DIR__).'/Controller/Image1.png',
            array(
                'width'         => 350,
                'height'        => 64,
                'marginTop'     => -100,
                'marginLeft'    => -1,
                'wrappingStyle' => 'behind'
            )
        );
        
        foreach($at as $k=>$d)
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
                   "Nom :                       ".$nom."<br/>".
                   "Prénom :                  ".$prenom."<br/>".
                   "Né(e) le :                  ".$date."<br/>".
                   "Lieu de naissance :  ".$lieu."<br/>".
                   "Adresse :                  ".$adresse."<br/><br/><br/>".
                   "Société immatriculée au R.C.S : ".$societe."<br/>".
                   "Adresse du siège : ".$siege."<br/><br/><br/>".
                   "No d’identification : ".$no."<br/>",
                    json_decode($d->getFontStyle(),true)
                );
                
            }
            $phpWord->addParagraphStyle('cfd'.$k,json_decode($d->getParagraphStyle(),true));
            $section->addText(
                $d->getText(),
                json_decode($d->getFontStyle(),true),
                'cfd'.$k
            );

        }

        $section->addImage(
            dirname(__DIR__).'/Controller/Image.png',
            array(
                'width'         => 200,
                'height'        => 64,
                'marginTop'     => -100,
                'marginLeft'    => -1,
                'wrappingStyle' => 'behind'
            )
        );
        
        $foot = $section->addFooter();
        $phpWord->addParagraphStyle('footer',["align"=>'center']);
        $foot->addText("CEFIOB Centre de Formation Banque Finance Assurance Immobilier".
        "91 Rue du Faubourg Saint-Honoré, 75008 Paris contact@cefiob.fr   https://cefiob.fr".
        "RCS Paris 753 159 490 00022 Centre de formation enregistré auprès de la DIRECCTE sous le N° 11754922175",
    
        ["size"=>10],'footer');
        // Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(uniqid().'.docx');

        return $this->render('generation/index.html.twig', [
            'controller_name' => 'GenerationController',
        ]);
    }
}
