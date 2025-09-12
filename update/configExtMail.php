<?php include('./../helper/logon.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include('./../helper/head.php'); ?>
</head>
<body>
  <?php include_once '../helper/alert.php'; ?>
  <?php include_once '../helper/menu.php'; ?>
    <div class="search-table">
        <div id="contacts">
            <h1>Configuración de Correos Externos</h1>
            <?php include_once '../helper/menuExt.php'; ?>
        </div>
        <div class="form-container">
            <form id="extMailForm">
                <div class="form-group" style="display: flex;width: 50%;margin: auto;margin-bottom: 17px;">
                    <label for="placa" style="display: none">Placa:</label>
                    <select id="placa" name="placa" required>
                        <option value="">Selecciona una placa</option>
                        <option value="BARCELONA">BARCELONA</option>
                        <option value="MADRID">MADRID</option>
                        <option value="SEVILLA">SEVILLA</option>
                        <option value="GRANADA">GRANADA</option>
                        <option value="PALMA">PALMA</option>
                        <option value="ZARAGOZA">ZARAGOZA</option>
                        <option value="VIGO">VIGO</option>
                        <option value="PATERNA">PATERNA</option>
                    </select>
                </div>  

                <div class="sections-container">
                    <div class="form-section">
                        <h3>Gestión</h3>
                        <div class="form-group">
                            <label for="gestion1" style="display: none">Gestión 1:</label>
                            <input type="email" id="gestion1" name="gestion1" placeholder="correo1@gestion.com">
                        </div>
                        <div class="form-group">
                            <label for="gestion2" style="display: none">Gestión 2:</label>
                            <input type="email" id="gestion2" name="gestion2" placeholder="correo2@gestion.com">
                        </div>
                        <div class="form-group">
                            <label for="gestion3" style="display: none">Gestión 3:</label>
                            <input type="email" id="gestion3" name="gestion3" placeholder="correo3@gestion.com">
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Almacén</h3>
                        <div class="form-group">
                            <label for="almacen1" style="display: none">Almacén 1:</label>
                            <input type="email" id="almacen1" name="almacen1" placeholder="correo1@almacen.com">
                        </div>
                        <div class="form-group">
                            <label for="almacen2" style="display: none">Almacén 2:</label>
                            <input type="email" id="almacen2" name="almacen2" placeholder="correo2@almacen.com">
                        </div>
                        <div class="form-group">
                            <label for="almacen3" style="display: none">Almacén 3:</label>
                            <input type="email" id="almacen3" name="almacen3" placeholder="correo3@almacen.com">
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Transporte</h3>
                        <div class="form-group">
                            <label for="transporte1" style="display: none">Transporte 1:</label>
                            <input type="email" id="transporte1" name="transporte1" placeholder="correo1@transporte.com">
                        </div>
                        <div class="form-group">
                            <label for="transporte2" style="display: none">Transporte 2:</label>
                            <input type="email" id="transporte2" name="transporte2" placeholder="correo2@transporte.com">
                        </div>
                        <div class="form-group">
                            <label for="transporte3" style="display: none">Transporte 3:</label>
                            <input type="email" id="transporte3" name="transporte3" placeholder="correo3@transporte.com">
                        </div>
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="submit" id="saveBtn">Guardar</button>
                </div>
            </form>
        </div>

        <div id="result-message" class="message" style="display: none;"></div>
        
        <div id="existing-data" class="data-table" style="display: none;">
            <h3>Datos Existentes</h3>
            <table>
                <thead>
                    <tr>
                        <th>Placa</th>
                        <th>Gestión</th>
                        <th>Almacén</th>
                        <th>Transporte</th>
                    </tr>
                </thead>
                <tbody id="data-tbody">
                </tbody>
            </table>
        </div>
    </div>
    
    <style>
        .form-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 20px;
            display: grid;
            align-items: center;
            gap: 10px;
        }
        
        .sections-container {
            display: flex;
            gap: 20px;
            flex-wrap: nowrap;
            justify-content: space-between;
            width: 100%;
        }
        
        .form-section {
            flex: 1;
            min-width: 300px;
            max-width: 350px;
            margin-bottom: 30px;
            padding: 15px;
            background: #ffffff;
            border-radius: 8px;
            border-left: 4px solid #317EFB;
        }
        
        @media (max-width: 1100px) {
            .sections-container {
                flex-wrap: wrap;
            }
        }
        
        @media (max-width: 768px) {
            .sections-container {
                flex-direction: column;
            }
            
            .form-section {
                min-width: auto;
                max-width: none;
            }
            
            .form-container {
                max-width: 90%;
            }
        }
        
        .form-section h3 {
            margin: 0 0 15px 0;
            color: #317EFB;
            font-size: 18px;
            font-weight: bold;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #317EFB;
            box-shadow: 0 0 5px rgba(49, 126, 251, 0.3);
        }
        
        .form-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 30px;
        }
        
        .form-buttons button {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        #saveBtn {
            background-color: #28a745;
            color: white;
        }
        
        #saveBtn:hover {
            background-color: #218838;
        }
        
        #loadBtn {
            background-color: #317EFB;
            color: white;
        }
        
        #loadBtn:hover {
            background-color: #2563eb;
        }
        
        #clearBtn {
            background-color: #6c757d;
            color: white;
        }
        
        #clearBtn:hover {
            background-color: #5a6268;
        }
        
        .message {
            margin: 20px auto;
            padding: 15px;
            border-radius: 4px;
            text-align: center;
            max-width: 600px;
        }
        
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .message.info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        .data-table {
            margin: 30px auto;
            max-width: 800px;
        }
        
        .data-table table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .data-table th,
        .data-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .data-table th {
            background-color: #317EFB;
            color: white;
            font-weight: bold;
        }
        
        .data-table tr:hover {
            background-color: #f5f5f5;
        }
    </style>
    
    
    <?php include('../helper/footer.php'); ?>
</body>
</html>
