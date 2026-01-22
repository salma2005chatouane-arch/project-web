<?php

function isEmployeInscrit($connexion, $session_id, $email)
{
    $email = mysqli_real_escape_string($connexion, $email);
    $session_id = (int) $session_id;

    $sql = "SELECT id FROM inscriptions 
            WHERE session_id = $session_id 
            AND email_employe LIKE '%$email%' 
            AND statut != 'annulee'";

    $result = mysqli_query($connexion, $sql);
    return $result && mysqli_num_rows($result) > 0;
}

function getSessionStatus($date_debut, $date_fin)
{
    $debut = strtotime($date_debut);
    $fin = strtotime($date_fin);
    $now = time();

    if ($now < $debut) {
        return [
            'label' => 'A venir',
            'style' => 'background: #dbeafe; color: #1e40af;'
        ];
    } elseif ($now >= $debut && $now <= $fin) {
        return [
            'label' => 'En cours',
            'style' => 'background: #fef3c7; color: #92400e;'
        ];
    } else {
        return [
            'label' => 'Terminee',
            'style' => 'background: #e5e7eb; color: #374151;'
        ];
    }
}

function renderSessionBadge($date_debut, $date_fin)
{
    $status = getSessionStatus($date_debut, $date_fin);
    return "<span style='padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.85rem; font-weight: 600; {$status['style']}'>{$status['label']}</span>";
}

function countSessionsFutures($connexion)
{
    $sql = "SELECT COUNT(*) as count FROM sessions WHERE date_debut >= CURDATE()";
    $result = mysqli_query($connexion, $sql);
    return $result ? mysqli_fetch_assoc($result)['count'] : 0;
}

function countFormations($connexion)
{
    $sql = "SELECT COUNT(*) as count FROM formations";
    $result = mysqli_query($connexion, $sql);
    return $result ? mysqli_fetch_assoc($result)['count'] : 0;
}

function countEmployesFormes($connexion)
{
    $sql = "SELECT COUNT(DISTINCT email_employe) as count FROM inscriptions";
    $result = mysqli_query($connexion, $sql);
    return $result ? mysqli_fetch_assoc($result)['count'] : 0;
}

function formatDateFr($date)
{
    return date('d/m/Y', strtotime($date));
}

function renderSuccessMessage($message)
{
    return "<div style='background: #d1fae5; border: 1px solid #10b981; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;'>
                " . htmlspecialchars($message) . "
            </div>";
}

function renderErrorMessage($message)
{
    return "<div style='background: #fee2e2; border: 1px solid #dc2626; color: #7f1d1d; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;'>
                " . htmlspecialchars($message) . "
            </div>";
}

function validateEmail($email)
{
    $email = trim($email);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $email;
    }
    return false;
}

function redirectWithMessage($page, $type, $message)
{
    $encoded_message = urlencode($message);
    header("Location: $page?{$type}=" . $encoded_message);
    exit;
}

function isSessionFuture($connexion, $session_id)
{
    $session_id = (int) $session_id;
    $sql = "SELECT date_debut FROM sessions WHERE id = $session_id AND date_debut > CURDATE()";
    $result = mysqli_query($connexion, $sql);
    return $result && mysqli_num_rows($result) > 0;
}

function getFormationById($connexion, $formation_id)
{
    $formation_id = (int) $formation_id;
    $sql = "SELECT * FROM formations WHERE id = $formation_id";
    $result = mysqli_query($connexion, $sql);
    return ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result) : null;
}

function getSessionById($connexion, $session_id)
{
    $session_id = (int) $session_id;
    $sql = "SELECT s.*, f.nom as formation_nom, form.nom as formateur_nom
            FROM sessions s
            JOIN formations f ON s.formation_id = f.id
            JOIN formateurs form ON s.formateur_id = form.id
            WHERE s.id = $session_id";
    $result = mysqli_query($connexion, $sql);
    return ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result) : null;
}
?>