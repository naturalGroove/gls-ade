<?php

namespace Webit\GlsAde\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Parcel
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 * @see https://ade-test.gls-poland.com/adeplus/pm1/html/webapi/structures/s_parcel.htm
 *
 * Tablica zawiera dane pojedynczej paczki z przesyłki.
 */
class Parcel
{

    /**
     * Numer paczki. W przypadku użycia struktury na wejściu element number jest ignorowany.
     * Struktura na wyjściu, w której pole number jest puste, oznacza że paczka nie ma nadanego numeru.
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("number")
     * @JMS\Groups({"input"})
     *
     */
    private string $number;

    /**
     * Referencje
     * (Opcja)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("reference")
     * @JMS\Groups({"input"})
     *
     */
    private string $reference;

    /**
     * Waga paczki [kg]. Waga pojedynczej paczki nie może być mniejsza od 0,01kg (10g).
     * (Opcja)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("weight")
     * @JMS\Groups({"input"})
     *
     */
    private string $weight;

    /**
     * Tablica z listą usług.
     *
     * @JMS\Type("Webit\GlsAde\Model\ServicesBool")
     * @JMS\SerializedName("srv_bool")
     * @JMS\Groups({"input"})
     *
     */
    private ServicesBool $srv_bool;

    /**
     * Usługi zapisane w standardzie ADE. Zawartość elementu użyta na wejściu jest ignorowana.
     * Przykład zawartości: COD 120.00PLN,EXW,ROD,POD,12:00.
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("srv_ade")
     * @JMS\Groups({"input"})
     *
     * @var string
     */
    private string $srv_ade;

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return string
     */
    public function getServiceAde()
    {
        return $this->srv_ade;
    }

    /**
     * @return ServicesBool
     */
    public function getServicesBool()
    {
        return $this->srv_bool;
    }

    /**
     * @param ServicesBool $servicesBool
     */
    public function setServicesBool($servicesBool)
    {
        $this->srv_bool = $servicesBool;
    }

    /**
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param string $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
}
