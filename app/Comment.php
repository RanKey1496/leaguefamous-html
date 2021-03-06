<?php

namespace App;

use DB;

class Comment
{
	public function find($id) { 
        return DB::select('SELECT * FROM comments WHERE id  = ?', [$id]);
    }

    public function getComments($summonerId, $region) { 
        return DB::select("SELECT * FROM comments WHERE summoner_id = ? AND summoner_region = ? AND deleted_at IS NULL AND parentId IS NULL ORDER BY created_at DESC", [$summonerId, $region]);
    }

    public function getCommentsv2($summonerId, $region) { 
        return DB::select("SELECT id,body,user_id,created_at,updated_at FROM comments WHERE summoner_id = ? AND summoner_region = ? AND deleted_at IS NULL AND parentId IS NULL ORDER BY created_at DESC", [$summonerId, $region]);
    }

    public function recent(){
        return DB::select("SELECT id,body,user_id,created_at,updated_at, summoner_id, summoner_region FROM comments WHERE created_at IN (SELECT MAX(created_at) FROM comments WHERE deleted_at IS NULL AND parentId IS NULL GROUP BY summoner_id, summoner_region) ORDER BY created_at DESC LIMIT 10");
    }

    public function getComment($user_id, $id) { 
        return DB::select("SELECT * FROM comments WHERE user_id=? AND id=? AND deleted_at IS NULL", [$user_id, $id]);
    }

    public function delete($user_id, $id) {
        return DB::update("UPDATE comments SET deleted_at = NOW() WHERE user_id=? AND id=?", [$user_id, $id]);
    }

    public function comments($summonerId, $region){
        return DB::select("SELECT COUNT(*) AS cont FROM comments WHERE summoner_id=? AND summoner_region=? AND deleted_at IS NULL", [$summonerId, $region]);
    }

    public function replys($id){
        return DB::select("SELECT * FROM comments WHERE parentId=? AND deleted_at IS NULL ORDER BY created_at DESC LIMIT 5", [$id]);
    }

    public function cntreplys($id){
        return DB::select("SELECT COUNT(*) AS cont FROM comments WHERE parentId=? AND deleted_at IS NULL", [$id]);
    }

    public function content($commentId){
        return DB::select("SELECT id,body,user_id,created_at,updated_at FROM comments WHERE id=? AND deleted_at IS NULL", [$commentId]);
    }

    public function contentReplys($commentId){
        return DB::select("SELECT id,body,user_id,created_at,updated_at FROM comments WHERE parentId=? AND deleted_at IS NULL", [$commentId]);
    }
}
