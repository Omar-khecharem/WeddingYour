<?php

namespace App\Controllers\Admin;

use App\Core\Request;
use App\Core\Response;
use App\Helpers\Security;
use App\Helpers\Image;

class OutletController extends BaseAdminController
{
    public function index(Request $request, Response $response): string
    {
        $this->setMeta('Outlets');
        $pdo = \App\Core\Database::getInstance()->getConnection();
        $outlets = $pdo->query("SELECT * FROM sg_outlets ORDER BY sort_order, name")->fetchAll(\PDO::FETCH_ASSOC);
        return $this->view('admin.outlets.index', ['outlets' => $outlets]);
    }

    public function create(Request $request, Response $response): string
    {
        $this->setMeta('Add Outlet');
        return $this->view('admin.outlets.form', ['outlet' => null]);
    }

    public function store(Request $request, Response $response): void
    {
        $data = [
            'name' => Security::sanitize($request->input('name', '')),
            'slug' => slugify($request->input('name', '')),
            'description' => Security::sanitize($request->input('description', '')),
            'address' => Security::sanitize($request->input('address', '')),
            'city' => Security::sanitize($request->input('city', '')),
            'state' => Security::sanitize($request->input('state', '')),
            'phone' => Security::sanitize($request->input('phone', '')),
            'email' => Security::sanitize($request->input('email', '')),
            'google_maps_link' => $request->input('google_maps_link', ''),
            'sort_order' => (int)$request->input('sort_order', 0),
            'is_active' => (int)(bool)$request->input('is_active', 1),
        ];

        $pdo = \App\Core\Database::getInstance()->getConnection();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Image::upload($file, UPLOADS_DIR . DS . 'outlets', $data['name']);
            if ($filename) $data['image'] = $filename;
        }

        $stmt = $pdo->prepare("INSERT INTO sg_outlets (name, slug, description, image, address, city, state, phone, email, google_maps_link, sort_order, is_active, created_at) VALUES (:name, :slug, :description, :image, :address, :city, :state, :phone, :email, :google_maps_link, :sort_order, :is_active, NOW())");
        $stmt->execute($data);

        $this->success('Outlet created.', url('admin/outlets'));
    }

    public function edit(Request $request, Response $response): string
    {
        $id = (int)$request->param('id');
        $pdo = \App\Core\Database::getInstance()->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM sg_outlets WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $outlet = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$outlet) {
            $this->flash('error', 'Outlet not found.');
            $this->redirect(url('admin/outlets'));
        }

        $this->setMeta('Edit: ' . $outlet['name']);
        return $this->view('admin.outlets.form', ['outlet' => $outlet]);
    }

    public function update(Request $request, Response $response): void
    {
        $id = (int)$request->param('id');
        $data = [
            'name' => Security::sanitize($request->input('name', '')),
            'description' => Security::sanitize($request->input('description', '')),
            'address' => Security::sanitize($request->input('address', '')),
            'city' => Security::sanitize($request->input('city', '')),
            'state' => Security::sanitize($request->input('state', '')),
            'phone' => Security::sanitize($request->input('phone', '')),
            'email' => Security::sanitize($request->input('email', '')),
            'google_maps_link' => $request->input('google_maps_link', ''),
            'sort_order' => (int)$request->input('sort_order', 0),
            'is_active' => (int)(bool)$request->input('is_active', 1),
            ':id' => $id,
        ];

        $pdo = \App\Core\Database::getInstance()->getConnection();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Image::upload($file, UPLOADS_DIR . DS . 'outlets', $data['name']);
            if ($filename) {
                $pdo->prepare("UPDATE sg_outlets SET image = :img WHERE id = :id")->execute([':img' => $filename, ':id' => $id]);
            }
        }

        $stmt = $pdo->prepare("UPDATE sg_outlets SET name = :name, description = :description, address = :address, city = :city, state = :state, phone = :phone, email = :email, google_maps_link = :google_maps_link, sort_order = :sort_order, is_active = :is_active WHERE id = :id");
        $stmt->execute($data);

        $this->success('Outlet updated.', url('admin/outlets'));
    }

    public function destroy(Request $request, Response $response): void
    {
        $id = (int)$request->input('id');
        $pdo = \App\Core\Database::getInstance()->getConnection();
        $pdo->prepare("DELETE FROM sg_outlets WHERE id = :id")->execute([':id' => $id]);
        $this->success('Outlet deleted.', url('admin/outlets'));
    }
}
