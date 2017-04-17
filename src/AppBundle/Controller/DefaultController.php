<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Top;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $memcached = $this->get('memcached');
        $cacheName = $this->getCacheName(__METHOD__);
        $result = $memcached->get($cacheName);

        if(!$result) {
            $inputDate = $request->get('date');

            try {
                $date = new \DateTime($inputDate);
            } catch (\Exception $e) {
                $date = new \DateTime();
            }

            $top = $this->getDoctrine()->getManager()->getRepository(Top::class)->findOneBy(['date' => $date]);

            $result = $this->render('default/index.html.twig', [
                'top' => $top,
            ]);

            $memcached->set($cacheName, $result, 60);
        }

        return $result;
    }

    /**
     * @param string $name
     * @return string
     */
    private function getCacheName($name = '')
    {
        $request = Request::createFromGlobals();
        $uri = $request->getUri();

        return

            $uri . '@' .
            ($this->getUser() ? $this->getUser()->getUsername() : 'anonymous') .
            '/' . $name;
    }
}
