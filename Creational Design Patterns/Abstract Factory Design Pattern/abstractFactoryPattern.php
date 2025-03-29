<?php

interface Button
{
    public function paint(): void;
}

interface Textbox
{
    public function paint(): void;
}

class WindowsButton implements Button
{
    public function paint(): void
    {
        echo "Windows Button Painted\n";
    }
}

class MacButton implements Button
{
    public function paint(): void
    {
       echo "Mac Button Painted\n";
    }
}

class WindowsTextbox implements Textbox
{
    public function paint(): void
    {
        echo "Windows Textbox Painted\n";
    }
}

class MacTextbox implements Textbox
{
    public function paint(): void
    {
        echo "Mac Textbox Painted\n";
    }
}

interface GUIFactory
{
    public function createButton(): Button;
    public function createTextbox(): Textbox;

}
class WindowsFactory implements GUIFactory
{
    public function createButton(): Button
    {
        return new WindowsButton();
    }

    public function createTextbox(): Textbox
    {
        return new WindowsTextbox();
    }
}

class MacFactory implements GUIFactory
{
    public function createButton(): Button
    {
        return new MacButton();
    }

    public function createTextbox(): Textbox
    {
        return new MacTextbox();
    }
}

class App
{
    private $factory;
    private $button;
    private $textbox;

    public function __construct(GUIFactory $guiFactory){
        $this->factory = $guiFactory;
    }

    public function generateGUI(){
        $this->button = $this->factory->createButton();
        $this->textbox = $this->factory->createTextbox();
    }

    public function paint(): void {
        $this->button->paint();
        $this->textbox->paint();
    }
}

class AppConfigrator
{
    public function main($os): void
    {
        $config = ['OS' => $os];

        switch ($os) {
            case 'Windows':
                $factory = new WindowsFactory();
                break;
            case 'Mac':
                $factory = new MacFactory();
                break;
            default:
                throw new Exception('OS not found!');
        }
        $app = new App($factory);
        $app->generateGUI();
        $app->paint();
    }
}

$appConfigurator = new AppConfigrator();
$appConfigurator->main('Windows');