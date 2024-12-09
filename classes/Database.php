<?php

class Database
{
	private string $file_name;
	private ?array $rows = [];

	public function __construct(string $file_name)
	{
		$this->file_name = $_SERVER['DOCUMENT_ROOT'] . '/databases/' . $file_name;
		if (!file_exists($this->file_name)) {
			trigger_error("File not found: " . $this->file_name, E_USER_ERROR);
		}
		$json = file_get_contents($this->file_name);
		$this->rows = json_decode($json, true);
	}

	public function write(): void
	{
		$file = fopen($this->file_name, "w");
		fwrite($file, json_encode($this->rows));
		fclose($file);
	}

	public function find(int $ID): ?array
	{
		foreach ($this->rows as $row) {
			if ($row['id'] == $ID) {
				return $row;
			}
		}

		return null;
	}

	public function set(int $ID, array $new_row): void
	{
		foreach ($this->rows as $i => $row) {
			if ($row['id'] == $ID) {
				$this->rows[$i] = $new_row;
			}
		}
	}

	public function all()
	{
		return $this->rows;
	}

	public function add(array $data)
	{
		$this->rows[] = $data;
	}
}