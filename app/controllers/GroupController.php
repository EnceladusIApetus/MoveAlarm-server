<?php

class GroupController extends BaseController {
	
	public function create() {
        $groupInfo = Input::all();
        if(Group::where('name', '=', $groupInfo['name'])->get()->count())
            return StatusDescriptor::createProcessStatus(false, "This name is already in use.");
        $user = User::find(intval($groupInfo['admin']['id']));
        $group = new Group;
        $group->name = $groupInfo['name'];
        $group->admin_id = $user->id;
        if(!$group->save())
            return StatusDescriptor::createProcessStatus(false, "An error has occured while saving data.");
        $progress = new GroupProgress;
        $progress->group()->associate($group);
        $progress->save();
        $user->group()->associate($group);
        if(!$user->save())
            return StatusDescriptor::createProcessStatus(false, "An error has occured while saving data.");
        $response = StatusDescriptor::createProcessStatus(true);
        $response['data'] = array('id' => $group->id);
        return $response;
	}

    public function findByUser()
    {
        $group = User::find(intval(Input::get('id')))->group()->get()->first();
        $group->admin = $group->admin();
        $group->member = $group->members()->get()->count();
        $group->members = $group->members()->get();
        $group->progress = $group->progress()->get()->first();
        return $group;
    }

    public function getTopRank()
    {
        $groups = Group::orderBy('score', 'desc')->take(intval(Input::get('max')))->get();
        foreach ($groups as $group) {
            $group->admin = $group->admin();
            $group->member = $group->members()->get()->count();
            $group->members = $group->members()->get();
            $group->progress = $group->progress()->get()->first();
        }
        return $groups;
    }

    public function getRank()
    {
        return Group::where('id', '!=', Input::get('id'))->where('score', '>', Input::get('score'))->get()->count() + 1;
    }

    public function getRankByUser()
    {
        $group = User::find(Input::get('id'))->group()->get()->first();
        return Group::where('id', '!=', $group->id)->where('score', '>', $group->score)->get()->count() + 1;
    }

    public function join()
    {
        $user = User::find(intval(Input::get('user')['id']));
        $group = Group::find(intval(Input::get('code')));
        if($group->members()->get()->count() > 10)
            return null;
        $user->group()->associate($group);
        $user->save();
        $group->save();
        $group->member = $group->members()->get()->count();
        $group->members = $group->members()->get();
        $group->admin = $group->admin();
        $group->progress = $group->progress()->get()->first();
        return $group;
    }

    public function leave()
    {
        $user = User::find(intval(Input::get('id')));
        $group = $user->group()->get()->first();
        if($group->admin_id == $user->id)
            return StatusDescriptor::createProcessStatus(false);
        $user->group()->dissociate();
        $user->save();
        return StatusDescriptor::createProcessStatus(true);
    }

    public function delete()
    {
        $user = User::find(intval(Input::get('id')));
        $group = $user->group()->get()->first();
        if($group->admin_id != $user->id)
            return StatusDescriptor::createProcessStatus(false);
        $users = $group->members()->get();
        foreach ($users as $user) {
            $user->group()->dissociate();
            $user->save();
        }
        $group->admin_id = null;
        $group->delete();
        return StatusDescriptor::createProcessStatus(true);
    }

    public function update()
    {
        $log = new ClientInputLog;
        $log->title = "on group update";
        $log->details = json_encode(Input::all());
        $log->save();
        $group = Group::find(intval(Input::get('id')));
        $group->updateData(Input::all());
        return StatusDescriptor::createProcessStatus(true);
    }

    /*public function addScore()
    {
        $data = Input::all();
        $event = Events::all()->last();
        $group = Group::find($data['id']);
        $group->score += $group->score;
        $progress = $group->progress()->first();
        if(intval($progress->updated_at->format('d')) != intval((new DateTime($event->time))->format('d'))){
            $progress->total++;
            $progress->
        }
    }*/
}