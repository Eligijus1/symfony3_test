<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Comment controller.
 *
 * @Route("/rabbit_producer_test_1")
 */
class RabbitProducerTest1Controller extends Controller
{
    /**
     * Lists all Comment entities.
     *
     * @Route("/", name="rabbit_producer_test_1_index")
     */
    public function indexAction()
    {
        return $this->render('Test1Bundle:rabbit_producer_test_1:index.html.twig');
    }

    /**
     * @Route("/produce", name="rabbit_producer_test_1_produce")
     */
    public function produceAction()
    {
        for ($i = 0; $i < 20; $i++) {
            $msg = new \stdClass();

            $msg->handle = 'handle';
            $msg->endpoint = 'endpoint';
            $msg->text = 'Test ' . $i;

            $this->get("rabbit_api_call_queue")->publish(json_encode($msg));
        }

        // return $this->redirectToRoute('rabbit_producer_test_1_index');
        return $this->render('Test1Bundle:rabbit_producer_test_1:produce.html.twig');
    }
}
