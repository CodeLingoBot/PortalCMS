<?php
/**
 * Class : Event (Event.php)
 * Details : Event Class.
 */
class Event
{
    /**
     * Check if an Event ID exists
     *
     * @param int $eventId The Id of the event
     *
     * @return bool
     */
    public static function doesEventIdExist($eventId)
    {
        $stmt = DB::conn()->prepare("SELECT id FROM events WHERE id = ? LIMIT 1");
        $stmt->execute([$eventId]);
        if ($stmt->rowCount() == 0) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Fetches an Event by Id
     *
     * @param int $eventId The Id of the event
     *
     * @return bool
     */
    public static function getEvent($eventId)
    {
        $stmt = DB::conn()->prepare("SELECT * FROM events WHERE id = ? LIMIT 1");
        $stmt->execute([$eventId]);
        if (!$stmt->rowCount() == 1) {
            return FALSE;
        }
        return $stmt->fetch();
    }

    public static function loadEvents($startDate, $endDate)
    {
        $startDateTime = $startDate.' 00:00:00';
        $endDateTime = $endDate.' 00:00:00';
        $data = array();
        $stmt = DB::conn()->prepare("SELECT * FROM events where start_event > ? and end_event < ? ORDER BY id");
        $stmt->execute([$startDateTime, $endDateTime]);
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $data[] = array(
                'id'   => $row["id"],
                'title'   => $row["title"],
                'start'   => $row["start_event"],
                'end'   => $row["end_event"]
            );
        }
        $returndata = json_encode($data);
        if (!empty($returndata)) {
            echo $returndata;
        }
    }

    public static function loadComingEvents()
    {
        $data = array();
        $now = date("Y-m-d H:i:s");
        $stmt = DB::conn()->prepare("SELECT * FROM events WHERE start_event > ? ORDER BY start_event asc limit 3");
        $stmt->execute([$now]);
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $data[] = array(
                'id'   => $row["id"],
                'title'   => $row["title"],
                'start'   => $row["start_event"],
                'end'   => $row["end_event"]
            );
        }
        $returndata = json_encode($data);
        if (!empty($returndata)) {
            echo $returndata;
        }
    }

    public static function loadStaticComingEvents()
    {
        $now = date("Y-m-d H:i:s");
        $stmt = DB::conn()->prepare("SELECT * FROM events WHERE start_event > ? ORDER BY start_event asc limit 3");
        $stmt->execute([$now]);
        $result = $stmt->fetchAll();
        foreach ($result as $row) {
            $title = $row["title"];
            $start = $row["start_event"];
            $end = $row["end_event"];
            $description = $row["description"];
            $returndata = '';
            $returndata .= '<strong>Naam evenement: '.$title.'</strong><br>Start: '.$start.'<br>Einde: '.$end.'<br><strong>Beschrijving</strong> '.$description.'<br>';
            if (!empty($returndata)) {
                return $returndata;
            }
        }
    }

    public static function addEvent()
    {
        $title = Request::post('title', TRUE);
        $start_event = Request::post('start_event', TRUE);
        $end_event = Request::post('end_event', TRUE);
        $description = Request::post('description', TRUE);

        $stmt = DB::conn()->prepare(
            "SELECT id
            FROM events
            WHERE start_event = ?
            AND end_event = ?"
        );
        $stmt->execute([$start_event, $end_event]);
        if (!$stmt->rowCount() == 0) {
            Session::add('feedback_negative', 'Kies een andere tijd.');
            return FALSE;
        }
        if (!self::addEventAction($title, $start_event, $end_event, $description)) {
            Session::add('feedback_negative', 'Toevoegen van evenement mislukt.');
            return FALSE;
        }
        Session::add('feedback_positive', 'Evenement toegevoegd.');
        return TRUE;
    }

    public static function addEventAction($title, $start_event, $end_event, $description)
    {
        $CreatedBy = Session::get('user_id');
        $stmt = DB::conn()->prepare(
            "INSERT INTO events(
                id, title, CreatedBy, start_event, end_event, description
            ) VALUES (
                NULL,?,?,?,?,?
            )"
        );
        $stmt->execute([$title, $CreatedBy, $start_event, $end_event, $description]);
        if (!$stmt) {
            return FALSE;
        }
        return TRUE;
    }


    public static function updateEvent()
    {
        $event_id = Request::post('id', TRUE);
        $title = Request::post('title', TRUE);
        $start_event = Request::post('start_event', TRUE);
        $end_event = Request::post('end_event', TRUE);
        $description = Request::post('description', TRUE);
        if (!self::doesEventIdExist($event_id)) {
            Session::add('feedback_negative', 'Wijzigen van evenement mislukt.<br>Evenement bestaat niet.');
            return FALSE;
        }
        if (!self::updateEventAction($event_id, $title, $start_event, $end_event, $description)) {
            Session::add('feedback_negative', 'Wijzigen van evenement mislukt.');
            return FALSE;
        }
        Session::add('feedback_positive', 'Evenement gewijzigd.');
        return TRUE;
    }

    public static function updateEventAction($event_id, $title, $start_event, $end_event, $description)
    {
        $stmt = DB::conn()->prepare(
            "UPDATE events
            SET title=?, start_event=?, end_event=?, description=?
            WHERE id=?"
        );
        $stmt->execute([$title, $start_event, $end_event, $description, $event_id]);
        if (!$stmt) {
            return FALSE;
        }
        return TRUE;
    }

    public static function updateDate($event_id, $title, $start_event, $end_event)
    {
        $stmt = DB::conn()->prepare(
            "UPDATE events
            SET title=?, start_event=?, end_event=?
            WHERE id=?"
        );
        $stmt->execute([$title, $start_event, $end_event, $event_id]);
        if (!$stmt) {
            return FALSE;
        }
        return TRUE;
    }

    public static function delete()
    {
        $event_id = Request::post('id', TRUE);
        $stmt = DB::conn()->prepare("SELECT * FROM events where id = ?");
        $stmt->execute([$event_id]);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $count = count($result);
        if ($count > 0) {
            if (self::deleteAction($event_id)) {
                Session::add('feedback_positive', 'Evenement verwijderd.');
                return TRUE;
            }
            Session::add('feedback_negative', 'Verwijderen van evenement mislukt.');
            return FALSE;
        }
        Session::add('feedback_negative', 'Verwijderen van evenement mislukt.<br>Evenement bestaat niet.');
        return FALSE;
    }

    public static function deleteAction($event_id)
    {
        $stmt = DB::conn()->prepare("DELETE FROM events WHERE id = ?");
        if ($stmt->execute([$event_id])) {
            return TRUE;
        }
        return FALSE;
    }

}
