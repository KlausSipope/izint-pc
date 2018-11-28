<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Controller\SecurityController as BaseSecurityController;

/**
 * @author Ioan Ovidiu Enache <i.ovidiuenache@yahoo.com>
 */
class SecurityController extends BaseSecurityController
{
    /**
     * @inheritdoc
     */
    public function loginAction(Request $request): Response
    {
        if (null !== $this->getUser()) {
            return $this->redirectToRoute('all_companies');
        }

        return parent::loginAction($request);
    }
}
