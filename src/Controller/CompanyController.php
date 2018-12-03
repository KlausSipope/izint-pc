<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Company;
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
        $queryBuilder = $companyRepository->all();
        $form = $this->createForm(SearchCompanyType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $queryBuilder = $companyRepository->filteredBy($formData['filterBy'], $formData['data']);
        }

        return $this->render(
            'pages/company/companies.html.twig',
            [
                'companies' => $this->get('knp_paginator')->paginate(
                    $queryBuilder,
                    $request->query->getInt('page', 1),
                    getenv('COMPANIES_PER_PAGE')
                ),
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @param Company $company
     *
     * @return Response
     *
     * @Route("/company/{id}", name="view_company")
     */
    public function companyAction(?Company $company): Response
    {
        if (null === $company) {
            $this->addFlash('error', $this->get('translator')->trans('errors.company.invalid.company'));

            return $this->redirectToRoute('all_companies');
        }

        return $this->render('pages/company/company.html.twig', ['company' => $company]);
    }
}
