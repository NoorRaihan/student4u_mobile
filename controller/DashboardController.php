<?php

    session_status() === PHP_SESSION_ACTIVE ?: session_start();

    include_once '../model/database.php';
    include_once '../model/User.php';
    include_once '../model/Paperwork.php';
    include_once '../model/Complaint.php';
    include_once '../model/Club.php';
    include_once '../controller/RoleValidation.php';

    $instance = Database::getInstance();
    $conn = $instance->getDBConnection();

    $curr_user = User::get_user($_SESSION['user_id']);

    function totalComplaint()
    {
        $complaint = Complaint::getAllComplaint();
        $count = 0;

        while($complaint->fetch_assoc()) {
            $count += 1;
        }
        return $count;
    }

    function totalComplaintByMode($status)
    {
        $complaint = Complaint::getAllComplaintByMode($status);
        $count = 0;

        while($complaint->fetch_assoc()) {
            $count += 1;
        }
        return $count;
    }

    function totalComplaintUID()
    {
        $complaint = Complaint::getAllComplaintByUID($_SESSION['user_id']);
        $count = 0;

        while($complaint->fetch_assoc()) {
            $count += 1;
        }
        return $count;
    }

    function totalComplaintByModeUID($status)
    {
        $complaint = Complaint::getAllComplaintByModeUID($status,$_SESSION['user_id']);
        $count = 0;

        while($complaint->fetch_assoc()) {
            $count += 1;
        }
        return $count;
    }

    function totalPaperwork()
    {
        $paperwork = Paperwork::getAllPaperworks();
        $count = 0;

        while($paperwork->fetch_assoc()) {
            $count += 1;
        }
        return $count;
    }

    function totalPaperworkByMode($status)
    {
        $paperwork = Paperwork::getAllPaperworksByMode($status);
        $count = 0;

        while($paperwork->fetch_assoc()) {
            $count += 1;
        }
        return $count;
    }

    function totalPaperworkUID()
    {
        $paperwork = Paperwork::getAllPaperworksByUID($_SESSION['user_id']);
        $count = 0;

        while($paperwork->fetch_assoc()) {
            $count += 1;
        }
        return $count;
    }

    function totalPaperworkByModeUID($status)
    {
        $paperwork = Paperwork::getAllPaperworksByModeUID($status,$_SESSION['user_id']);
        $count = 0;

        while($paperwork->fetch_assoc()) {
            $count += 1;
        }
        return $count;
    }

    function totalUser()
    {
        $complaint = User::getAllUser();
        $count = 0;

        while($complaint->fetch_assoc()) {
            $count += 1;
        }
        return $count;
    }

    function totalClub()
    {
        $complaint = Club::getAllClubs();
        $count = 0;

        while($complaint->fetch_assoc()) {
            $count += 1;
        }
        return $count;
    }


    function complaintResponseTime()
    {
        $resp = Complaint::responseTime();
        $sum = 0;
        $total = 0;

        while($data = $resp->fetch_assoc()) {
            $sum += $data['DIFFERENCE'];
            $total += 1;
        }

        //find average
        if($total == 0) {
            return hoursandmins(0, '%02d Hours, %02d Minutes');
        }else{
            $avg = $sum / $total;
            return hoursandmins($sum, '%02d Hours, %02d Minutes');
        }
    }

    function paperworkResponseTime()
    {
        $resp = Paperwork::responseTime();
        $sum = 0;
        $total = 0;

        while($data = $resp->fetch_assoc()) {
            $sum += $data['DIFFERENCE'];
            $total += 1;
        }

        //find average
        if($total == 0) {
            return hoursandmins(0, '%02d Hours, %02d Minutes');
        }else{
            $avg = $sum / $total;
            return hoursandmins($sum, '%02d Hours, %02d Minutes');
        }
    }

    function hoursandmins($time, $format = '%02d:%02d')
    {
        if ($time < 1) {
            return sprintf($format, 0, 0);
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);

        return sprintf($format, $hours, $minutes);
    }

    if($role == 2) {
        $complaintTotal = totalComplaint();
        $complaintPending = totalComplaintByMode('IN PROGRESS');
        $complaintApproved = totalComplaintByMode('APPROVED');
        $complaintRejected = totalComplaintByMode('REJECTED');
        $paperworkTotal = totalPaperwork();
        $paperworkPending = totalPaperworkByMode('IN PROGRESS');
        $paperworkApproved = totalPaperworkByMode('APPROVED');
        $paperworkRejected = totalPaperworkByMode('REJECTED');
        $complaintResponse = complaintResponseTime();
        $paperworkResponse = paperworkResponseTime();
        $totalUser = totalUser();
        $totalClub = totalClub();
    }else if($role == 1) {
        $complaintTotal = totalComplaintUID();
        $complaintPending = totalComplaintByModeUID('IN PROGRESS');
        $complaintApproved = totalComplaintByModeUID('APPROVED');
        $complaintRejected = totalComplaintByModeUID('REJECTED');
        $paperworkTotal = totalPaperworkUID();
        $paperworkPending = totalPaperworkByModeUID('IN PROGRESS');
        $paperworkApproved = totalPaperworkByModeUID('APPROVED');
        $paperworkRejected = totalPaperworkByModeUID('REJECTED');
    }
?>