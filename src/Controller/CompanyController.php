<?php declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\SearchCompanyType;
use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Ioan Ovidiu Enache <i.ovidiuenache@yahoo.com>
 */
class CompanyController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/company/all", name="all_companies")
     */
    public function companiesAction(Request $request): Response
    {
        $companyRepository = $this->get(CompanyRepository::class);

        $form = $this->createForm(SearchCompanyType::class);
        $form->handleRequest($request);
        $allCompaniesQueryBuilder = $companyRepository->createQueryBuilder('e');
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = array_filter($form->getData());
            $allCompaniesQueryBuilder
                ->andWhere($allCompaniesQueryBuilder->expr()->like("e.{$formData['filterBy']}", ':data'))
                ->setParameter('data', '%' . ($formData['data'] ?? $formData['status']) . '%');
        }

        return $this->render(
            'pages/company/companies.html.twig',
            [
                'companies' => $this->get('knp_paginator')->paginate(
                    $allCompaniesQueryBuilder,
                    $request->query->getInt('page', 1),
                    getenv('COMPANIES_PER_PAGE')
                ),
                'form' => $form->createView()
            ]
        );
    }
}
