<?php
/**
 * File: PickupApi.php
 * Created at: 2014-11-24 06:28
 */
 
namespace Webit\GlsAde\Api;

use Webit\GlsAde\Model\Consignment;
use Webit\GlsAde\Model\ConsignmentLabelModes;
use Webit\GlsAde\Model\Pickup;
use Webit\GlsAde\Model\PickupReceiptModes;

/**
 * Class PickupApi
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 * @see https://ade-test.gls-poland.com/adeplus/pm1/html/webapi/function_list.htm
 * Potwierdzenia nadania
 */
class PickupApi extends AbstractSessionAwareApi
{
    /**
     * Metoda pozwala na stworzenie potwierdzenia nadania z wybranych z przygotowalni przesyłek.
     * Paczki bez numerów otrzymują je automatycznie. Przesyłki, które znalazły się w nowo utworzonym potwierdzeniu
     * nadania otrzymują nowe identyfikatory (czyli są one różne od tych z przygotowalni).
     * @see https://ade-test.gls-poland.com/adeplus/pm1/html/webapi/functions/f_pickup_create.htm
     *
     * @param array $consignmentIds
     * @param string $description
     * @return int
     */
    public function createPickup(array $consignmentIds, $description)
    {
        $response = $this->request(
            'adePickup_Create',
            array('consigns_ids' => $consignmentIds, 'desc' => $description)
        );

        return $response;
    }

    /**
     * Metoda pozwala uzyskać identyfikatory potwierdzeń nadania.
     * Zwracanych jest nie więcej niż 100 identyfikatorów uporządkowanych malejąco.
     *
     * Pierwsze wywołanie funkcji powinno się odbyć z parametrem id_start = 0. Zostanie wtedy zwróconych
     * nie więcej niż 100 identyfikatorów uporządkowanych malejąco (tym samym pierwsze wywołanie funkcji daje
     * zawsze najnowsze identyfikatory) mniejszych niż id_start. Jeśli zwróconych zostanie mniej niż
     * 100 identyfikatorów, oznacza to że zostały pobrane wszystkie. Natomiast jeśli zostanie zwróconych
     * 100 identyfikatorów, należy wywołać funkcję przynajmniej jeszcze jeden raz, podając jako parametr
     * id_start wartość ostatniego elementu tablicy identyfikatorów otrzymanej w poprzednim wywołaniu.
     * Kolejne wywołanie będzie konieczne, jeśli liczba identyfikatorów bedzie równa 100. Zatem aby otrzymać
     * pełną listę identyfikatorów należy wywoływać metodę tyle razy, aż na wyjściu pojawi się tablica
     * z mniej niż 100 identyfikatorami.
     * @see https://ade-test.gls-poland.com/adeplus/pm1/html/webapi/functions/f_pickup_get_ids.htm
     *
     * @param int $idStart
     * @return array
     */
    public function getPickupIds($idStart = 0)
    {
        $response = $this->request('adePickup_GetIDs', array('id_start' => $idStart));

        return $response;
    }

    /**
     * Pobiera infromacje na temat potwierdzenia nadania.
     * @see https://ade-test.gls-poland.com/adeplus/pm1/html/webapi/functions/f_pickup_get.htm
     *
     * @param $id
     * @return Pickup
     */
    public function getPickup($id)
    {
        $response = $this->request('adePickup_Get', array('id' => $id));

        return $response;
    }

    /**
     * Metoda daje dostęp do danych przesyłki z potwierdzenia nadania.
     * @see https://ade-test.gls-poland.com/adeplus/pm1/html/webapi/functions/f_pickup_get_consign.htm
     *
     * @param int $id
     * @return Consignment
     */
    public function getConsignment($id)
    {
        $response = $this->request('adePickup_GetConsign', array('id' => $id));

        return $response;
    }

    /**
     * Metoda pobiera druk potwierdzenia nadania.
     * @see https://ade-test.gls-poland.com/adeplus/pm1/html/webapi/functions/f_pickup_get_receipt.htm
     *
     * @param int $id
     * @return string
     */
    public function getPickupReceipt($id, $mode = PickupReceiptModes::MODE_CONDENSED)
    {
        $response = $this->request('adePickup_GetReceipt', array('id' => $id, 'mode' => $mode));
//        array(
//            receipt | string - Plik z potwierdzeniem (zakodowany MIME base64)
//        )
        return $response;
    }

    /**
     * Metoda pobiera z systemu etykiety ze wszystkich przesyłek z pojedynczego potwierdzenia nadania.
     * @see https://ade-test.gls-poland.com/adeplus/pm1/html/webapi/functions/f_pickup_get_labels.htm
     *
     * @param int $id
     * @param string $mode
     * @return string
     */
    public function getPickupLabels($id, $mode = ConsignmentLabelModes::MODE_ONE_LABEL_ON_A4_PDF)
    {
        $response = $this->request('adePickup_GetLabels', array('id' => $id, 'mode' => $mode));
//        array(
//            labels | string - Plik z etykietami (zakodowany MIME base64)
//        )
        return $response;
    }

    /**
     * Metoda pobiera druki IDENT z potwierdzenia nadania.
     * @see https://ade-test.gls-poland.com/adeplus/pm1/html/webapi/functions/f_pickup_get_ident.htm
     */
    public function getIdentPrint($id)
    {
        $response = $this->request('adePickup_GetIdent', array('id' => $id));
//        array(
//            ident | string - Plik z drukami IDENT (zakodowany MIME base64)
//        )
        return $response;
    }

    /**
     * Pozwala pobrać z systemu etykiety dla przesyłki znajdującej się na dowolnym potwierdzeniu nadania.
     * @see https://ade-test.gls-poland.com/adeplus/pm1/html/webapi/functions/f_pikcup_get_consign_labels.htm
     *
     * @param $id
     * @param string $mode
     * @return string
     */
    public function getConsignmentLabels($id, $mode = ConsignmentLabelModes::MODE_ONE_LABEL_ON_A4_PDF)
    {
        $response = $this->request('', array('id' => $id, 'mode' => $mode));
//        array(
//            labels | string - Plik z etykietami (zakodowany MIME base64)
//        )
        return $response;
    }

    /**
     * Metoda pozwala uzyskać dane przesyłki, na podstawie numeru paczki.
     * Poszukiwanie dotyczy wyłącznie paczek z istniejących potwierdzeń nadania
     * (czyli wszytskich znajdujących się poza przygotowalnią).
     * @see https://ade-test.gls-poland.com/adeplus/pm1/html/webapi/functions/f_pickup_parcel_num_search.htm
     *
     * @param string $number
     * @return Consignment
     */
    public function searchParcel($number)
    {
        $response = $this->request('adePickup_ParcelNumberSearch', array('number' => $number));

        return $response;
    }
}
