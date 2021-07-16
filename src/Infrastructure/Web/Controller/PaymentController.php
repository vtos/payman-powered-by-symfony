<?php
/**
 * This file is part of the vtos/payment application.
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 *
 * @copyright 2021 Vitaly Potenko <potenkov@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 * @link https://github.com/vtos/payman GitHub
 */

declare(strict_types=1);

namespace Payman\Infrastructure\Web\Controller;

use Payman\Infrastructure\Web\Form\UploadPaymentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PaymentController extends AbstractController
{
    /**
     * @Route("/payment/upload", name="upload_payment")
     */
    public function upload(): Response
    {

//        return $this->render('payment/noplan.html.twig');


        $form = $this->createForm(
            UploadPaymentType::class,
            [],
            [
                'payment_plans_options' => [
                    '1' => 'Option 1',
                    '2' => 'Option 2',
                ],
            ]
        );

        return $this->render(
            'payment/upload.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
