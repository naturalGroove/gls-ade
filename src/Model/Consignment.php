<?php

namespace Webit\GlsAde\Model;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * Class Consignment
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 * @see https://ade-test.gls-poland.com/adeplus/pm1/html/webapi/structures/s_consign.htm
 *
 * Tablica transportuje dane na temat przesyłki oraz paczek.
 *
 * Szczególną uwagę należy zwrócić na właściwe wykorzystanie tej struktury dla usług PR, PS, EXC i SRS,
 * ponieważ zasadniczej zmianie ulega wykorzystanie elementów związanych z adresami (doręczenia, odbioru).
 * Uwagi na ten temat są podane w opisie tablicy ServicePPE.
 *
 * Sekcja z prefiksem r (od rrname1 do rcontact) w przypadku usług PR, PS, EXC i SRS
 * nie musi być wypełniana (odpowiednie dane zostaną pobrane z tablicy ServicePPE).
 */
class Consignment
{

    /**
     * Identyfikator przesyłki
     *
     * @var int
     */
    private $id;

    /**
     * Pierwsza część nazwy odbiorcy (tzw. Nazwa 1)
     * (Wymagany)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("rname1")
     * @JMS\Groups({"input"})
     *
     * @var string
     */
    private $rname1;

    /**
     * Druga część nazwy odbiorcy (tzw. Nazwa 2)
     * (Opcja)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("rname2")
     * @JMS\Groups({"input"})
     *
     * @var string
     */
    private $rname2;

    /**
     * Trzecia część nazwy odbiorcy (tzw. Nazwa 3)
     * (Opcja)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("rname3")
     * @JMS\Groups({"input"})
     *
     * @var string
     */
    private $rname3;

    /**
     * Kod kraju odbiorcy (zgodny z ISO 3166-1 alfa-2)
     * (Wymagany)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("rcountry")
     * @JMS\Groups({"input"})
     *
     * @var string
     */
    private $rcountry;

    /**
     * Kod pocztowy odbiorcy
     * (Wymagany)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("rzipcode")
     * @JMS\Groups({"input"})
     *
     * @var string
     */
    private $rzipcode;

    /**
     * Nazwa miejscowości odbiorcy
     * (Wymagany)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("rcity")
     * @JMS\Groups({"input"})
     *
     * @var string
     */
    private $rcity;

    /**
     * Ulica odbiorcy
     * (Wymagany)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("rstreet")
     * @JMS\Groups({"input"})
     *
     * @var string
     */
    private $rstreet;

    /**
     * Telefony do odbiorcy
     * (Opcja)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("rphone")
     * @JMS\Groups({"input"})
     *
     * @var string
     */
    private $rphone;

    /**
     * Email, osoba kontaktowa odbiorcy
     * (string)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("rcontact")
     * @JMS\Groups({"input"})
     *
     * @var string
     */
    private $rcontact;

    /**
     * Referencje (pole to jest drukowane na etykietach, zazwyczaj podaje się
     * w tym polu skrócony opis zawartości paczki, nr zamównienia etc.)
     * (Opcja)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("references")
     * @JMS\Groups({"input"})
     *
     * @var string
     */
    private $references;

    /**
     * Uwagi
     * (Opcja)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("notes")
     * @JMS\Groups({"input"})
     *
     * @var string
     */
    private $notes;

    /**
     * Ilość paczek w przesyłce, zawartość pola jest automatycznie korygowana
     * na podstawie zawartości elementów tablicy z paczkami.
     * (Opcja)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("quantity")
     * @JMS\Groups({"input"})
     *
     * @var string
     */
    private $quantity;

    /**
     * Waga wszystkich paczek w przesyłce [kg], zawartość pola jest automatycznie korygowana
     * na podstawie zawartości elementów tablicy z paczkami.
     * (Opcja)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("weight")
     * @JMS\Groups({"input"})
     *
     * @var string
     */
    private $weight;

    /**
     * Data nadania, jeśli brak zostanie wstawiona aktualna data [YYYY-MM-DD]
     * (Opcja)
     *
     * @JMS\Type("DateTime<'Y-m-d'>")
     * @JMS\SerializedName("date")
     * @JMS\Groups({"input"})
     *
     * @var \DateTime
     */
    private $date;

    /**
     * Identyfikator MPK (patrz opis metody adePfc_GetStatus)
     * (Opcja)
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("pfc")
     * @JMS\Groups({"input"})
     *
     * @var string
     */
    private $pfc;

    /**
     * Adres nadawcy (patrz opis metody adeSendAddr_GetStatus)
     * (Opcja)
     *
     * @JMS\Type("Webit\GlsAde\Model\SenderAddress")
     * @JMS\SerializedName("sendaddr")
     * @JMS\Groups({"input"})
     *
     * @var SenderAddress
     */
    private $sendaddr;

    /**
     * Tablica z listą usług
     * (Opcja)
     *
     * @JMS\Type("Webit\GlsAde\Model\ServicesBool")
     * @JMS\SerializedName("srv_bool")
     * @JMS\Groups({"input"})
     *
     * @var ServicesBool
     */
    private $srv_bool;

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
    private $srv_ade;

    /**
     * Tablica z danymi usługi DAW
     * (Opcja)
     *
     *
     * @JMS\Type("Webit\GlsAde\Model\ServiceDaw")
     * @JMS\SerializedName("srv_daw")
     * @JMS\Groups({"input"})
     *
     * @var ServiceDaw
     */
    private $srv_daw;

    /**
     * Tablica z danymi usługi IDENT
     * (Opcja)
     *
     *
     * @JMS\Type("Webit\GlsAde\Model\ServiceIdent")
     * @JMS\SerializedName("srv_ident")
     * @JMS\Groups({"input"})
     *
     * @var ServiceIdent
     */
    private $srv_ident;

    /**
     * Tablica z danymi usług PR, PS, EXC i SRS
     * (Opcja)
     *
     * @JMS\Type("Webit\GlsAde\Model\ServicePpe")
     * @JMS\SerializedName("srv_ppe")
     * @JMS\Groups({"input"})
     *
     * @var ServicePpe
     */
    private $srv_ppe;

    /**
     * Tablica z paczkami. W przypadku zastosowania struktury na wejściu, usługi podane
     * w poszczególnych paczkach są ignorowane i zastępowane przez usługi podane w elemencie srv_bool (nadrzędnym).
     * Opcja
     *
     *
     * @JMS\Type("ArrayCollection<Webit\GlsAde\Model\Parcel>")
     * @JMS\SerializedName("parcels")
     * @JMS\Groups({"input"})
     *
     * @var ArrayCollection
     */
    private $parcels;

    /**
     * Flag, if consignment has been fetched from "Prepare" or "Pickup"
     * @var bool
     */
    private $dispatched = false;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getRCity()
    {
        return $this->rcity;
    }

    /**
     * @param string $city
     */
    public function setRCity($rcity)
    {
        $this->rcity = $rcity;
    }

    /**
     * @return string
     */
    public function getRContact()
    {
        return $this->rcontact;
    }

    /**
     * @param string $contact
     */
    public function setRContact($rcontact)
    {
        $this->rcontact = $rcontact;
    }

    /**
     * @return string
     */
    public function getRCountry()
    {
        return $this->rcountry;
    }

    /**
     * @param string $rcountry
     */
    public function setRCountry($rcountry)
    {
        $this->rcountry = $rcountry;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getRName1()
    {
        return $this->rname1;
    }

    /**
     * @param string $rname1
     */
    public function setRName1($rname1)
    {
        $this->rname1 = $rname1;
    }

    /**
     * @return string
     */
    public function getRName2()
    {
        return $this->rname2;
    }

    /**
     * @param string $rname2
     */
    public function setRName2($rname2)
    {
        $this->rname2 = $rname2;
    }

    /**
     * @return string
     */
    public function getRName3()
    {
        return $this->rname3;
    }

    /**
     * @param string $rname3
     */
    public function setRName3($rname3)
    {
        $this->rname3 = $rname3;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param string $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * @return ArrayCollection
     */
    public function getParcels()
    {
        if ($this->parcels == null) {
            $this->parcels = new ArrayCollection();
        }

        return $this->parcels;
    }

    /**
     * @param Parcel $parcel
     */
    public function addParcel(Parcel $parcel)
    {
        if (! $this->getParcels()->contains($parcel)) {
            $this->getParcels()->add($parcel);
        }
    }

    /**
     * @param Parcel $parcel
     */
    public function removeParcel(Parcel $parcel)
    {
        $this->getParcels()->removeElement($parcel);
    }

    /**
     * @return string
     */
    public function getPfc()
    {
        return $this->pfc;
    }

    /**
     * @param string $pfc
     */
    public function setPfc($pfc)
    {
        $this->pfc = $pfc;
    }

    /**
     * @return string
     */
    public function getRPhone()
    {
        return $this->rphone;
    }

    /**
     * @param string $phone
     */
    public function setRPhone($rphone)
    {
        $this->rphone = $rphone;
    }

    /**
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getReferences()
    {
        return $this->references;
    }

    /**
     * @param string $references
     */
    public function setReferences($references)
    {
        $this->references = $references;
    }

    /**
     * @return SenderAddress
     */
    public function getSenderAddress()
    {
        return $this->sendaddr;
    }

    /**
     * @param SenderAddress $senderAddress
     */
    public function setSenderAddress(SenderAddress $senderAddress = null)
    {
        $this->sendaddr = $senderAddress;
    }

    /**
     * @return ServiceDaw
     */
    public function getServiceDaw()
    {
        return $this->srv_daw;
    }

    /**
     * @param ServiceDaw $serviceDaw
     */
    public function setServiceDaw(ServiceDaw $serviceDaw = null)
    {
        $this->srv_daw = $serviceDaw;
    }

    /**
     * @return ServiceIdent
     */
    public function getServiceIdent()
    {
        return $this->srv_ident;
    }

    /**
     * @param ServiceIdent $serviceIdent
     */
    public function setServiceIdent(ServiceIdent $serviceIdent = null)
    {
        $this->srv_ident = $serviceIdent;
    }

    /**
     * @return ServicePpe
     */
    public function getServicePpe()
    {
        return $this->srv_ppe;
    }

    /**
     * @param ServicePpe $servicePpe
     */
    public function setServicePpe(ServicePpe $servicePpe = null)
    {
        $this->srv_ppe = $servicePpe;
    }

    /**
     * @return string
     */
    public function getServicesAde()
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
    public function setServicesBool(ServicesBool $servicesBool)
    {
        $this->srv_bool = $servicesBool;
    }

    /**
     * @return string
     */
    public function getRStreet()
    {
        return $this->rstreet;
    }

    /**
     * @param string $street
     */
    public function setRStreet($rstreet)
    {
        $this->rstreet = $rstreet;
    }

    /**
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     */
    public function setWeight($weight)
    {
        $this->weight = (string)$weight;
    }

    /**
     * @return string
     */
    public function getRZipCode()
    {
        return $this->rzipcode;
    }

    /**
     * @param string $rZipCode
     */
    public function setRZipCode($rzipcode)
    {
        $this->rzipcode = $rzipcode;
    }

    /**
     * @return bool
     */
    public function isDispatched()
    {
        return $this->dispatched;
    }

    public function setDispatched($dispatched)
    {
        $this->dispatched = (bool) $dispatched;
    }
}
