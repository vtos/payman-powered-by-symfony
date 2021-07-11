<?php
/**
 * This file is part of the vtos/payment-powered-by-symfony application.
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 *
 * @copyright 2021 Vitaly Potenko <potenkov@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3 or later
 * @link https://github.com/vtos/payman-powered-by-symfony GitHub
 */

declare(strict_types=1);

namespace Payman\Infrastructure\Web\Form;

use Payman\Domain\Model\Payment\Payment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class UploadPaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', TextType::class)
            ->add('upload', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Payment::class,
            ]
        );
    }
}
