<?php

namespace App\Controller;

use App;
use App\Table\Settings;
use Core\Controller\AbstarctController;
use Core\Form\Type\PasswordType;
use Core\Form\Type\SubmitType;
use Core\Form\Type\TextType;
use Core\Route\Route;

class AdminController extends AbstarctController
{
    private  $app;

    public function __construct()
    {
        $this->app = App::getInstance();
        if (!$this->app->isAdmin()) {
            $this->headLocation("/account");
        }
    }

    #[Route('/admin')]
    public function admin()
    {
        return $this->render('/admin/index.php', '/admin.php', [
            'title' => 'Admin | Accueil',
        ]);
    }

    #[Route('/admin/settings')]
    public function settings()
    {
        $SettingsTable = new Settings();
        $setting = $SettingsTable->findOne();

        $form_builder = $this->createForm()
            ->add("location", TextType::class, ['value' => ($setting ? $setting->getLocation() : ""), 'data-req' => true, 'label' => 'Location', 'id' => 'locaiton'])
            ->add("email", TextType::class, ['value' => ($setting ? $setting->getEmail() : ""), 'data-req' => true, 'label' => 'Email', 'id' => 'email'])
            ->add("email_pass", PasswordType::class, ['value' => ($setting ? $setting->getEmail_pass() : ""), 'data-req' => true, 'label' => "Email password", 'id' => 'email_pass'])
            ->add("server", TextType::class, ['value' => ($setting ? $setting->getServer() : ""), 'data-req' => true, 'label' => 'Server name', 'id' => 'server'])
            ->add("port", TextType::class, ['value' => ($setting ? $setting->getPort() : ""), 'data-req' => true, 'label' => 'Port smtp', 'id' => 'port'])
            ->add("email_security", TextType::class, ['value' => ($setting ? $setting->getEmail_security() : ""), 'data-req' => true, 'label' => 'Email security', 'id' => 'email_security'])
            ->add("num", TextType::class, ['value' => ($setting ? $setting->getNum() : ""), 'data-req' => true, 'label' => 'Phone number', 'id' => 'num'])
            ->add("facebook", TextType::class, ['value' => ($setting ? $setting->getFacebook() : ""), 'data-req' => true, 'label' => 'Facebook link', 'id' => 'facebook'])
            ->add("instagram", TextType::class, ['value' => ($setting ? $setting->getInstagram() : ""), 'data-req' => true, 'label' => 'Instagram link', 'id' => 'instagram'])
            ->add("etp_name", TextType::class, ['value' => ($setting ? $setting->getEtp_name() : ""), 'data-req' => true, 'label' => 'Company name', 'id' => 'etp_name'])
            ->add("first_name", TextType::class, ['value' => ($setting ? $setting->getFirst_name() : ""), 'data-req' => true, 'label' => 'First name', 'id' => 'first_name'])
            ->add("last_name", TextType::class, ['value' => ($setting ? $setting->getLast_name() : ""), 'data-req' => true, 'label' => 'Last name', 'id' => 'last_name'])
            ->add("statut", TextType::class, ['value' => ($setting ? $setting->getStatut() : ""), 'data-req' => true, 'label' => 'Statut', 'id' => 'statut'])
            ->add("immatriculation_number", TextType::class, ['value' => ($setting ? $setting->getImmatriculation_number() : ""), 'data-req' => true, 'label' => 'Immatriculation number', 'id' => 'immatriculation_number'])
            ->add("host_name", TextType::class, ['value' => ($setting ? $setting->getHost_name() : ""), 'data-req' => true, 'label' => 'Host name', 'id' => 'host_name'])
            ->add("host_location", TextType::class, ['value' => ($setting ? $setting->getHost_location() : ""), 'data-req' => true, 'label' => 'Host location', 'id' => 'host_location'])
            ->add("host_number", TextType::class, ['value' => ($setting ? $setting->getHost_number() : ""), 'data-req' => true, 'label' => 'Host number', 'id' => 'host_number'])
            ->add("submit", SubmitType::class, ['value' => 'save'])
            ->getForm();

        if ($form_builder->isSubmit()) {
            $error = $form_builder->isXmlValid($SettingsTable);
            if ($error->noError()) {
                $data = $form_builder->getData();

                $class = ($setting ? $setting : $SettingsTable);
                $class
                    ->setLocation($data['location'])
                    ->setEmail($data['email'])
                    ->setEmail_pass($data['email_pass'])
                    ->setServer($data['server'])
                    ->setPort($data['port'])
                    ->setEmail_security($data['email_security'])
                    ->setNum($data['num'])
                    ->setFacebook($data['facebook'])
                    ->setInstagram($data['instagram'])
                    ->setEtp_name($data['etp_name'])
                    ->setFirst_name($data['first_name'])
                    ->setLast_name($data['last_name'])
                    ->setStatut($data['statut'])
                    ->setImmatriculation_number($data['immatriculation_number'])
                    ->setHost_name($data['host_name'])
                    ->setHost_location($data['host_location'])
                    ->setHost_number($data['host_number'])
                    ->flush();

                $_SESSION["message"] = $error->success("successfully " . ($setting ? "update" : "insert"));
                $error->location(URL . "/admin/settings", "success_location");
            }
            $error->getXmlMessage($this->app->getProperties(Settings::class));
        }

        return $this->render('/app/register.php', '/admin.php', [
            'title' => 'Admin | Settings',
            'form' => $form_builder->createView(),
        ]);
    }
}
