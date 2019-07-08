<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\Livre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for ($i = 1; $i <= 8; $i++){
            $livre = new Livre();

            $livre->setTitle("Titre du blog n°$i")
                ->setAuthor("Autor")
                ->setCard("Fiche technique")
                ->setCoverImage("http://plahold.it/800x600")
                ->setDescription("

<p>Constituendi autem sunt qui sint in amicitia fines et quasi termini diligendi. De quibus tres video sententias ferri, quarum nullam probo, unam, ut eodem modo erga amicum adfecti simus, quo erga nosmet ipsos, alteram, ut nostra in amicos benevolentia illorum erga nos benevolentiae pariter aequaliterque respondeat, tertiam, ut, quanti quisque se ipse facit, tanti fiat ab amicis.</p>

<p>Tantum autem cuique tribuendum, primum quantum ipse efficere possis, deinde etiam quantum ille quem diligas atque adiuves, sustinere. Non enim neque tu possis, quamvis excellas, omnes tuos ad honores amplissimos perducere, ut Scipio P. Rupilium potuit consulem efficere, fratrem eius L. non potuit. Quod si etiam possis quidvis deferre ad alterum, videndum est tamen, quid ille possit sustinere.</p>

<p>Montius nos tumore inusitato quodam et novo ut rebellis et maiestati recalcitrantes Augustae per haec quae strepit incusat iratus nimirum quod contumacem praefectum, quid rerum ordo postulat ignorare dissimulantem formidine tenus iusserim custodiri.</p>
");

            for ($j = 1; $j <= mt_rand(2,5); $j++){
                $image = new Image();

                $image->setUrl("http://plahold.it/1200x600")
                    ->setCaption("Texte de l'image")
                    ->setLivre($livre);

                $manager->persist($image);
            }

            $manager->persist($livre);
        }


        $manager->flush();
    }
}
